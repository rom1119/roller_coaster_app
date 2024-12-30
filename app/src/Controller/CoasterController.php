<?php

declare(strict_types=1);

namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CoasterController extends AbstractFOSRestController
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    #[Route('/api', methods:'POST')]
    #[IsGranted('PUBLIC_ACCESS')]
    public function createAction(
        #[MapRequestPayload(
            validationFailedStatusCode: Response::HTTP_BAD_REQUEST
        )] $arg
        
        
    ) {


        try {

        } catch ( $e) {
            $view = $this->view([
                'error' => $e->getMessage()
            ], 400);
            return $this->handleView($view);
        }

        $view = $this->view($result, 200);
        return $this->handleView($view);
    }

    #[Route('/api/exclude/{id}', name: 'exclude', methods: ['DELETE'])]
    public function deleteAction( ): JsonResponse
    {

        return new JsonResponse(['message' => ' excluded']);
    }



}
