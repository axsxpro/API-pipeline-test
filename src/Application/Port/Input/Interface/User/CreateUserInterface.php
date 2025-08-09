<?php

namespace App\Application\Port\Input\Interface\User;

use App\Application\DTO\UserDto\Input\CreateUserDto;
use App\Application\DTO\UserDto\Output\UserResponseDto;

interface CreateUserInterface
{
    public function execute(CreateUserDto $createUserDto): UserResponseDto;

}