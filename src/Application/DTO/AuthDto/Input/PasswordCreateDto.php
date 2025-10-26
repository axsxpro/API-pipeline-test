<?php

namespace App\Application\DTO\AuthDto\Input;

use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "PasswordCreateDto",
    description: "Creation d'un nouveau mot de passe",
    properties: [
        new OA\Property(
            property: "plainPassword",
            type: "string",
            example: "Password123!"
        ),
    ]
)]
class PasswordCreateDto
{
    public function __construct(

        #[Assert\NotBlank]
        public string $plainPassword,
    ) {}
}