<?php

namespace App\Application\DTO\UserDto\Input;

use App\Application\DTO\RoleDto\Input\RoleDto;
use Symfony\Component\Validator\Constraints as Assert;

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
        #[Assert\DateTime(format: 'd-m-y')]
        public string $birthdate,

        #[Assert\NotBlank]
        public RoleDto $role,

        public ?string $plainPassword = null
    ) {}
}
