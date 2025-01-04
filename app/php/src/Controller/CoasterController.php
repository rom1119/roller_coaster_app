<?php

declare(strict_types=1);

namespace App\Controller;

use App\Api\ApiProblem;
use App\Api\ApiProblemException;
use App\Domain\Model\Coaster;
use App\Domain\CoasterFacade;
use App\Domain\Model\Wagon;
use App\Form\CreateCoasterType;
use App\Form\CreateWagonType;
use App\Form\UpdateCoasterType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsController]
class CoasterController extends AbstractFOSRestController
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private CoasterFacade $coasterFacade
    ) {
    }

    #[Route('/api/coasters', methods:'POST')]
    public function createAction(
        Request $request  
    ) {
        $model = new Coaster();
        $form = $this->createForm(CreateCoasterType::class, $model);
        $this->processRequest($request, $form);

        $data = $this->coasterFacade->addCoaster($model);

        return $this->createApiResponse($data, Response::HTTP_CREATED);
    }

    #[Route('/api/coasters/{coasterId}', methods:'PUT')]
    public function updateAction(
        string $coasterId,
        Request $request
    ) {

        $model = $this->coasterFacade->findCoaster($coasterId);
        if (!$model) {
            throw $this->createNotFoundException();
        }
        $form = $this->createForm(UpdateCoasterType::class, $model);
        $this->processRequest($request, $form);

        $data = $this->coasterFacade->updateCoaster($model, $coasterId);

        return $this->createApiResponse($data, Response::HTTP_OK);
    }

    #[Route('/api/coasters/{coasterId}/wagons', methods:'POST')]
    public function addWagonAction(
        string $coasterId,
        Request $request
    ) {

        $model = new Wagon();
        $form = $this->createForm(CreateWagonType::class, $model);
        $this->processRequest($request, $form);

        $data = $this->coasterFacade->addWagon($model, $coasterId);

        return $this->createApiResponse($data, Response::HTTP_OK);
    }

    #[Route('/api/coasters/{coasterId}/wagons/{wagonId}', methods: ['DELETE'])]
    public function deleteWagonAction(         
        string $coasterId,
        string $wagonId,
        Request $request
    )
    {
        $this->coasterFacade->deleteWagon($coasterId, $wagonId);

        return $this->createApiResponse(null, Response::HTTP_NO_CONTENT);
    }

    protected function createApiResponse($data, int $status = Response::HTTP_CREATED) : Response {
        $view = $this->view($data, $status);
        $view->setHeader('Content-Type', 'application/json');

        return $this->handleView($view);
    }

    protected function processRequest(Request $request, FormInterface $form) {
        
        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            $apiProblem = new ApiProblem(400, ApiProblem::TYPE_INVALID_REQUEST_BODY_FORMAT);

            throw new ApiProblemException($apiProblem);
        }

        $clearMissing = $request->getMethod() != 'PATCH';
        $form->submit($data);

        if (!$form->isValid()) {
            $this->throwApiProblemValidationException($form);
        }
        
    }

    protected function getErrorsFromForm(FormInterface $form)
    {
        $errors = array();
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }

        return $errors;
    }

    protected function throwApiProblemValidationException(FormInterface $form)
    {
        $errors = $this->getErrorsFromForm($form);

        $apiProblem = new ApiProblem(
            400,
            ApiProblem::TYPE_VALIDATION_ERROR
        );
        $apiProblem->set('errors', $errors);

        throw new ApiProblemException($apiProblem);
    }



}
