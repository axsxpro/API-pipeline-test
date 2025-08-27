<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Role;
use App\Domain\Enum\RoleEnum;
use App\Domain\Port\Output\Interface\Repository\RoleRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Role>
 */
class RoleRepository extends ServiceEntityRepository implements RoleRepositoryInterface
{
    public function __construct(ManagerRegistry $registry, private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Role::class);
    }

    public function findByName(RoleEnum $name): ?Role
    {
        return $this->findOneBy(['name' => $name]);
    }

    public function save(Role $role): void
    {
        $this->entityManager->persist($role);
        $this->entityManager->flush();
    }
}
