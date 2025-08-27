<?php

namespace App\Domain\Port\Output\Interface\Repository;

use App\Domain\Entity\Role;
use App\Domain\Enum\RoleEnum;


interface RoleRepositoryInterface{

    public function save(Role $role): void;
    public function findByName(RoleEnum $name): ?Role;
}