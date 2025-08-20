<?php

namespace App\Application\DTO\UserDto\Output;

class UserListResponseDto
{
    public function __construct(

        /**
         * @var UserResponseDto[]
         */
        public array $users
    ) {}
}