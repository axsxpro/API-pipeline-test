<?php

namespace App\Application\UseCase\User;

use App\Application\DTO\UserDto\Input\CreateUserDto;
use App\Application\DTO\UserDto\Output\UserResponseDto;
use App\Application\Mapper\UserMapper;
use App\Application\Port\Input\Interface\User\CreateUserInterface;
use App\Domain\Exception\ConflictException;
use App\Domain\Port\Output\Interface\Repository\UserRepositoryInterface;
use App\Domain\Service\Auth\AuthCreationService;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class CreateUserUseCase implements CreateUserInterface
{
    
    public function __construct(
        private AuthCreationService         $authCreationService,
        private UserRepositoryInterface     $userRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function execute(CreateUserDto $createUserDto): UserResponseDto
    {
        if ($this->userRepository->findUserByEmail($createUserDto->email)) {
            throw new ConflictException('User already exists.');
        }

        $user = UserMapper::mapCreateDtoToEntity($createUserDto);

        if ($createUserDto->plainPassword) {

            $hashedPassword = $this->passwordHasher->hashPassword($user, $createUserDto->plainPassword);
            $auth = $this->authCreationService->initAuthPassword($hashedPassword);

            $user->setAuth($auth);
        }

        $this->userRepository->save($user);

        $userResponseDto = UserMapper::mapEntityToDto($user);

        return $userResponseDto;
    }
}