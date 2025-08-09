<?php

namespace App\Application\UseCase\User;

use App\Application\DTO\UserDto\Input\CreateUserDto;
use App\Application\DTO\UserDto\Output\UserResponseDto;
use App\Application\Mapper\UserMapper;
use App\Application\Port\Input\Interface\User\CreateUserInterface;
use App\Domain\Port\Output\Interface\Repository\UserRepositoryInterface;
use App\Domain\Service\Auth\AuthCreationService;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUserUseCase implements CreateUserInterface
{
    
    public function __construct(
        private readonly AuthCreationService $authCreationService,
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {}

    public function execute(CreateUserDto $createUserDto): UserResponseDto
    {
        $user = UserMapper::mapCreateDtoToEntity($createUserDto);

        if ($createUserDto->plainPassword) {

            $hashedPassword = $this->passwordHasher->hashPassword($user, $createUserDto->plainPassword);
            $auth = $this->authCreationService->initAuthPassword($hashedPassword);

            $user->setAuth($auth);
        }


        return new UserResponseDto();
    }
}