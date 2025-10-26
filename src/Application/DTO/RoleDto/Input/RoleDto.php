<?php

namespace App\Application\DTO\RoleDto\Input;

use App\Domain\Enum\RoleEnum;
use Symfony\Component\Validator\Constraints as Assert;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "RoleDto", //nom de la classe
    description: "Données du rôle d'un utilisateur",
    properties: [
        new OA\Property(
            property: "name",
            type: "string",
            example: "ROLE_USER"
        ),
    ]
)]
class RoleDto
{
    public function __construct(

        #[Assert\NotBlank]
        public RoleEnum $name,
    ) {}

}