<?php

namespace App\Application\UseCase\Role;


use App\Application\DTO\RoleDto\Input\RoleDto;
use App\Application\DTO\RoleDto\Output\RoleResponseDto;
use App\Application\Mapper\RoleMapper;
use App\Application\Port\Input\Interface\Role\CreateRoleInterface;
use App\Domain\Exception\ConflictException;
use App\Domain\Exception\ValidationException;
use App\Domain\Port\Output\Interface\Repository\RoleRepositoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


readonly class CreateRoleUseCase implements CreateRoleInterface
{
    public function __construct(
        private RoleRepositoryInterface $roleRepository,
        private ValidatorInterface      $validator
    ) {}

    public function execute(RoleDto $roleDto): RoleResponseDto
    {
        $errors = $this->validator->validate($roleDto);
        if (count($errors) > 0) {
            throw new ValidationException('Error during role creation.');
        }

        $existingRole = $this->roleRepository->findByName($roleDto->name);
        if ($existingRole) {
            throw new ConflictException('Role already exists.');
        }

        $role = RoleMapper::mapDtoToEntity($roleDto);

        $this->roleRepository->save($role);

        return RoleMapper::mapEntityToDto($role);
    }
}