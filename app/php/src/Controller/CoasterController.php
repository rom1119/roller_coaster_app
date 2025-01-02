<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\Exception\GeneralRollerCoasterError;
use App\Domain\Model\Coaster;
use App\Domain\CoasterFacade;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[AsController]
class CoasterController extends AbstractFOSRestController
{
    // public function __construct(
    //     private EntityManagerInterface $em,
    // ) {
    // }

    #[Route('/api/coasters', methods:'POST')]
    public function createAction(
        #[MapRequestPayload(
            validationFailedStatusCode: Response::HTTP_BAD_REQUEST
        )] Coaster $arg,
        CoasterFacade $coasterFacade
        
        
    ) {
        // $container->logError('asdas');

        try {

            $response = $coasterFacade->addCoaster($arg);

        } catch (GeneralRollerCoasterError $e) {
            $view = $this->view([
                'error' => $e->getMessage()
            ], 400);
            return $this->handleView($view);
        }
        $view = $this->view(['item' => 'ok ', 'aaa' => $response], 200);
        return $this->handleView($view);
    }

    #[Route('/api/exclude/{id}', name: 'exclude', methods: ['DELETE'])]
    public function deleteAction( ): JsonResponse
    {

        return new JsonResponse(['message' => ' excluded']);
    }



}
