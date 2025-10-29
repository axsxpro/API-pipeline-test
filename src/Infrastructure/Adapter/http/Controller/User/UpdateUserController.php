<?php

namespace App\Infrastructure\Adapter\http\Controller\User;

use App\Application\DTO\UserDto\Input\UpdateUserDto;
use App\Application\Port\Input\Interface\User\UpdateUserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class UpdateUserController extends AbstractController
{

    public function __construct(
        private readonly UpdateUserInterface $updateUserInterface
    ) {}


    #[Route('/api/patch/users/{id}', name: 'app_user_patch', methods: ['PATCH'])]
    #[OA\Patch(
        path: '/api/patch/users/{id}',
        summary: 'Update user fields (admin only)',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/UpdateUserDto')
        ),
        tags: ['Users'],
        responses: [
            new OA\Response(response: 200, description: 'User successfully updated.'),
            new OA\Response(response: 404, description: 'User not found.')
        ]
    )]
    public function updateUser(int $id, #[MapRequestPayload] UpdateUserDto $updateUserDto): JsonResponse
    {
        $userResponseDto = $this->updateUserInterface->execute($id, $updateUserDto);

        return new JsonResponse($userResponseDto, JsonResponse::HTTP_OK);
    }
}