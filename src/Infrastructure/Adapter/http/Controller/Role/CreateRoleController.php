<?php

namespace App\Infrastructure\Adapter\http\Controller\Role;

use App\Application\DTO\RoleDto\Input\RoleDto;
use App\Application\Port\Input\Interface\Role\CreateRoleInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class CreateRoleController extends AbstractController
{
    public function __construct(
        private readonly CreateRoleInterface $createRoleInterface
    ) {}

    #[Route('/api/post/role', name: "app_role_post", methods: ['POST'])]
    #[OA\Post(
        path: "/api/post/role",
        summary: "Create a new role",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/RoleDto")
        ),
        tags: ["Role"],
        responses: [
            new OA\Response(response: 201, description: "Created")
        ]
    )]
    public function createRole( #[MapRequestPayload] RoleDto $roleDto): JsonResponse
    {
        $roleResponse = $this->createRoleInterface->execute($roleDto);

        return new JsonResponse($roleResponse, JsonResponse::HTTP_CREATED);
    }

}