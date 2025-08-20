<?php

namespace App\Domain\Port\Output\Interface\Repository;

use App\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;
    public function findUserByEmail(string $email): ?User;
    public function findAllUsers(): array;

}