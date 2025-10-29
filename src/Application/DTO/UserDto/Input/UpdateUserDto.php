<?php

namespace App\Application\DTO\UserDto\Input;

use App\Application\DTO\RoleDto\Input\RoleDto;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateUserDto
{
    public function __construct(
        #[Assert\Email]
        public ?string $email = null,

        public ?string $name = null,

        public ?string $firstname = null,

        #[Assert\DateTime(format: 'd-m-Y')]
        public ?string $birthdate = null,

        public ?RoleDto $role = null
    ) {}

}