<?php

namespace App\Application\Port\Input\Interface\Auth;

use App\Application\DTO\AuthDto\Input\PasswordCreateDto;

interface CreateAuthInterface
{
    public function execute(int $id, PasswordCreateDto $passwordCreateDto): void;

}