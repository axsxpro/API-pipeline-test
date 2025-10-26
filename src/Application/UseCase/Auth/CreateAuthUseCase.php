<?php

namespace App\Application\UseCase\Auth;

use App\Application\DTO\AuthDto\Input\PasswordCreateDto;
use App\Application\Port\Input\Interface\Auth\CreateAuthInterface;
use App\Domain\Exception\ConflictException;
use App\Domain\Exception\ResourceNotFoundException;
use App\Domain\Exception\ValidationException;
use App\Domain\Port\Output\Interface\Repository\UserRepositoryInterface;
use App\Domain\Service\Auth\AuthCreationService;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class CreateAuthUseCase implements CreateAuthInterface
{

    public function __construct(
        private UserRepositoryInterface     $userRepository,
        private ValidatorInterface          $validator,
        private UserPasswordHasherInterface $passwordHasher,
        private AuthCreationService         $authCreationService,
    ) {}

    public function execute(int $id, PasswordCreateDto $passwordCreateDto): void
    {
        $errors = $this->validator->validate($passwordCreateDto);
        if (count($errors) > 0) {
            throw new ValidationException('Invalid password data.');
        }

        $user = $this->userRepository->find($id);
        if (!$user) {
            throw new ResourceNotFoundException('User not found.');
        }

        if ($user->getAuth()) {
            throw new ConflictException('Password already exists for this user.');
        }

        $hashedPassword = $this->passwordHasher->hashPassword($user, $passwordCreateDto->plainPassword);
        $auth = $this->authCreationService->initAuthPassword($hashedPassword);
        $user->setAuth($auth);

        $this->userRepository->save($user);
    }
}