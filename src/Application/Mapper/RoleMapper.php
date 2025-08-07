<?php

namespace App\Application\Mapper;

use App\Application\DTO\RoleDto\Input\RoleDto;
use App\Application\DTO\RoleDto\Output\RoleResponseDto;
use App\Domain\Entity\Role;

class RoleMapper
{
    public static function  mapEntityToDto(Role $role): RoleResponseDto
    {
        return new RoleResponseDto(
            name: $role->getName()->value,
        );
    }

    public static function mapDtoToEntity(RoleDto $roleDto): Role
    {

        $role = new Role();

        $role->setName($roleDto->name);

        return $role;
    }
}