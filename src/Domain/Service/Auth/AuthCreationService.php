<?php

namespace App\Domain\Service\Auth;

use App\Domain\Entity\Auth;
use DateTimeImmutable;

class AuthCreationService
{
    public function initAuthPassword(string $hashedPassword): Auth
    {
        $auth = new Auth();
        $auth->setPassword($hashedPassword);
        $auth->setPasswordCreatedAt(new DateTimeImmutable());
        return $auth;
    }
}