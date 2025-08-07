<?php

namespace App\Application\DTO\UserDto\Output;

class UserResponseDto
{
    public function __construct(
        public int $id,
        public string $email,
        public string $name,
        public string $firstname,
        public string $birthdate,
        public string $role,
        public string $createdAt
    ) {}

}