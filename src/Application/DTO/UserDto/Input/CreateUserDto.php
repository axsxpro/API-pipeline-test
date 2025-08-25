<?php

namespace App\Application\DTO\UserDto\Input;

use App\Application\DTO\RoleDto\Input\RoleDto;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "CreateUserDto",
    description: "Données nécessaires pour créer un utilisateur",
    properties: [
        new OA\Property(property: "email", type: "string", format: "email", example: "user@example.com"),
        new OA\Property(property: "name", type: "string",  example: "Doe"),
        new OA\Property(property: "firstname", type: "string",  example: "John"),
        new OA\Property(property: "birthdate", type: "string", format: "date", example: "01-01-1990"),
        new OA\Property(property: "plainPassword", type: "string",  example: "Password123!"),
    ]
)]
class CreateUserDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email]
        public string $email,

        #[Assert\NotBlank]
        public string $name,

        #[Assert\NotBlank]
        public string $firstname,

        #[Assert\NotBlank]
        #[Assert\DateTime(format: 'd-m-Y')]
        public string $birthdate,

        #[Assert\NotBlank]
        public RoleDto $role,

        public ?string $plainPassword = null
    ) {}
}
