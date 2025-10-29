<?php

namespace App\Application\Port\Input\Interface\User;

use App\Application\DTO\UserDto\Input\UpdateUserDto;
use App\Application\DTO\UserDto\Output\UserResponseDto;

interface UpdateUserInterface
{
    public function execute(int $userId, UpdateUserDto $dto): UserResponseDto;
}