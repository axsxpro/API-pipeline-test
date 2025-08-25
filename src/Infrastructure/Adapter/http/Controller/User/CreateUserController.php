<?php

namespace App\Infrastructure\Adapter\http\Controller\User;

use App\Application\DTO\UserDto\Input\CreateUserDto;
use App\Application\Port\Input\Interface\User\CreateUserInterface;
use App\Domain\Exception\ValidationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use OpenApi\Attributes as OA;


class CreateUserController extends AbstractController
{
    public function __construct(
        private readonly CreateUserInterface $createUser
    ) {}

    #[Route('/api/post/users', name: "app_users_post", methods: ['POST'])]
    #[OA\Post(
        path: "/api/users",
        summary: "Créer un nouvel utilisateur",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/CreateUserDto")
        ),
        responses: [
            new OA\Response(response: 201, description: "Created")
        ]
    )]
    public function createUsers( #[MapRequestPayload] CreateUserDto $createUserDto, ValidatorInterface $validator): JsonResponse
    {
        $errors = $validator->validate($createUserDto);
        if (count($errors) > 0) {
            throw new ValidationException('Data validation error when creating a user.');
        }

        $userResponseDto = $this->createUser->execute($createUserDto);

        return new JsonResponse($userResponseDto, JsonResponse::HTTP_CREATED);

    }

}