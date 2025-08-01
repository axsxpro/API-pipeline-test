<?php

namespace App\Domain\Enum;

enum RoleEnum: string
{
    case ROLE_USER = 'ROLE_USER';
    case ROLE_MANAGER = 'ROLE_MANAGER';
    case ROLE_ADMIN = 'ROLE_ADMIN';


    public static function getAvailableRoles(): array
    {
        return [
            self::ROLE_USER,
            self::ROLE_MANAGER,
            self::ROLE_ADMIN,
        ];
    }
}
