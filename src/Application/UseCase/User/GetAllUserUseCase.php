<?php

namespace App\Application\UseCase\User;

use App\Application\DTO\UserDto\Output\UserListResponseDto;
use App\Application\Mapper\UserMapper;
use App\Domain\Port\Output\Interface\Repository\UserRepositoryInterface;

readonly class GetAllUserUseCase
{

    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function execute(): UserListResponseDto
    {
        $users = $this->userRepository->findAllUsers();
        $userListDtos = array_map(
            fn($user) => UserMapper::mapEntityToDto($user),
            $users
        );

        return new UserListResponseDto($userListDtos);
    }
}