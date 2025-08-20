<?php

namespace App\Infrastructure\Adapter\http\Controller\User;

use App\Application\UseCase\User\GetAllUserUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetAllUserController extends abstractController
{

    public function __construct(
        private readonly GetAllUserUseCase $getAllUserUseCase
    ){}

    #[Route('/api/users', name: 'app_users', methods: ['GET'])]
    public function getUsers(): JsonResponse
    {
        $usersDto = $this->getAllUserUseCase->execute();

        return new JsonResponse($usersDto, Response::HTTP_OK);
    }
}