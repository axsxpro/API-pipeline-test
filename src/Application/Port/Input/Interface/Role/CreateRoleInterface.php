<?php

namespace App\Application\Port\Input\Interface\Role;

use App\Application\DTO\RoleDto\Input\RoleDto;
use App\Application\DTO\RoleDto\Output\RoleResponseDto;

interface CreateRoleInterface
{
    public function execute(RoleDto $roleDto): RoleResponseDto;
}