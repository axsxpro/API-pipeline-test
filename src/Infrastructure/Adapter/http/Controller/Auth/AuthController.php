<?php

namespace App\Infrastructure\Adapter\http\Controller\Auth;

use App\Application\DTO\AuthDto\Input\PasswordCreateDto;
use App\Application\Port\Input\Interface\Auth\CreateAuthInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class AuthController extends abstractController
{
    public function __construct(
        private readonly CreateAuthInterface $createAuthInterface
    ) {}

    #[Route('/api/post/auth/{id}', name: 'create_user_password', methods: ['POST'])]
    #[OA\Post(
        path: "/api/post/auth/{id}",
        summary: "Create password for an user.",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/PasswordCreateDto")
        ),
        tags: ["Auth"],
        responses: [
            new OA\Response(response: 201, description: "Created")
        ]
    )]
    public function createAuth(int $id, #[MapRequestPayload] PasswordCreateDto $passwordCreateDto): JsonResponse
    {
        $this->createAuthInterface->execute($id, $passwordCreateDto);

        return new JsonResponse(['message' => 'Password successfully created.'],JsonResponse::HTTP_CREATED);
    }

}