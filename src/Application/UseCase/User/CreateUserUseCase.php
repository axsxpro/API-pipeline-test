<?php

namespace App\Application\UseCase\User;

use App\Application\DTO\UserDto\Input\CreateUserDto;
use App\Application\DTO\UserDto\Output\UserResponseDto;
use App\Application\Mapper\UserMapper;
use App\Application\Port\Input\Interface\User\CreateUserInterface;
use App\Domain\Exception\ConflictException;
use App\Domain\Exception\ResourceNotFoundException;
use App\Domain\Exception\ValidationException;
use App\Domain\Port\Output\Interface\Repository\RoleRepositoryInterface;
use App\Domain\Port\Output\Interface\Repository\UserRepositoryInterface;
use App\Domain\Service\Auth\AuthCreationService;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class CreateUserUseCase implements CreateUserInterface
{
    
    public function __construct(
        private AuthCreationService         $authCreationService,
        private UserRepositoryInterface     $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private RoleRepositoryInterface     $roleRepository,
        private ValidatorInterface          $validator
    ) {}

    public function execute(CreateUserDto $createUserDto): UserResponseDto
    {
        $errors = $this->validator->validate($createUserDto);
        if (count($errors) > 0) {
            throw new ValidationException('Data validation error when creating a user.');
        }

        if ($this->userRepository->findUserByEmail($createUserDto->email)) {
            throw new ConflictException('User already exists.');
        }

        $role = $this->roleRepository->findByName($createUserDto->role->name);
        if (!$role) {
            throw new ResourceNotFoundException("Role not found.");
        }

        $user = UserMapper::mapCreateDtoToEntity($createUserDto);
        $user->setRole($role);

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