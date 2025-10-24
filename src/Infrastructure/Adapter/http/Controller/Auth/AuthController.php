<?php

namespace App\Infrastructure\Adapter\http\Controller\Auth;

use App\Application\DTO\AuthDto\Input\PasswordCreateDto;
use App\Application\Port\Input\Interface\Auth\CreateAuthInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends abstractController
{
    public function __construct(
        private readonly CreateAuthInterface $createAuthInterface
    ) {}

    #[Route('/api/auth/{id}', name: 'create_user_password', methods: ['POST'])]
    public function createAuth( #[MapRequestPayload] int $id, PasswordCreateDto $passwordCreateDto): JsonResponse
    {
        $this->createAuthInterface->execute($id, $passwordCreateDto);

        return new JsonResponse(['message' => 'Password successfully created.'],JsonResponse::HTTP_CREATED);
    }

}