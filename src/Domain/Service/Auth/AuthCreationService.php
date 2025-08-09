<?php

namespace App\Domain\Service\Auth;

use App\Domain\Entity\Auth;

class AuthCreationService
{
    public function initAuthPassword(string $hashedPassword): Auth
    {
        $auth = new Auth();
        $auth->setPassword($hashedPassword);
        return $auth;
    }
}