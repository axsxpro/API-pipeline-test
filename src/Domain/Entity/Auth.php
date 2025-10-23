<?php

namespace App\Domain\Entity;

use App\Infrastructure\Repository\AuthRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AuthRepository::class)]
class Auth
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern: '/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
        message: 'The password must contain at least one uppercase letter, one digit, and one special character.'
    )]
    private ?string $password = null;

    #[ORM\OneToOne(inversedBy: 'auth')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'CASCADE')]
    private ?User $user = null;


    #[ORM\Column]
    private ?DateTimeImmutable $passwordCreatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $passwordLastChanged = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPasswordCreatedAt(): ?DateTimeImmutable
    {
        return $this->passwordCreatedAt;
    }

    public function setPasswordCreatedAt(DateTimeImmutable $passwordCreatedAt): static
    {
        $this->passwordCreatedAt = $passwordCreatedAt;

        return $this;
    }

    public function getPasswordLastChanged(): ?DateTimeImmutable
    {
        return $this->passwordLastChanged;
    }

    public function setPasswordLastChanged(?DateTimeImmutable $passwordLastChanged): static
    {
        $this->passwordLastChanged = $passwordLastChanged;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

}
