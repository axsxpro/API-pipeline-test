<?php

namespace App\Domain\Entity;

use App\Infrastructure\Repository\ProjectRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $isOpenSource = null;

    #[ORM\Column]
    private ?DateTime $deadline = null;

    #[ORM\Column(nullable: true)]
    private ?float $estimatedBudget = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'projects')]
    private Collection $users;

    /**
     * @var Collection<int, Framework>
     */
    #[ORM\ManyToMany(targetEntity: Framework::class, inversedBy: 'projects')]
    private Collection $frameworks;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->frameworks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isOpenSource(): ?bool
    {
        return $this->isOpenSource;
    }

    public function setIsOpenSource(bool $isOpenSource): static
    {
        $this->isOpenSource = $isOpenSource;

        return $this;
    }

    public function getDeadline(): ?DateTime
    {
        return $this->deadline;
    }

    public function setDeadline(DateTime $deadline): static
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function getEstimatedBudget(): ?float
    {
        return $this->estimatedBudget;
    }

    public function setEstimatedBudget(?float $estimatedBudget): static
    {
        $this->estimatedBudget = $estimatedBudget;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addProject($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeProject($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Framework>
     */
    public function getFrameworks(): Collection
    {
        return $this->frameworks;
    }

    public function addFramework(Framework $framework): static
    {
        if (!$this->frameworks->contains($framework)) {
            $this->frameworks->add($framework);
        }

        return $this;
    }

    public function removeFramework(Framework $framework): static
    {
        $this->frameworks->removeElement($framework);

        return $this;
    }
}
