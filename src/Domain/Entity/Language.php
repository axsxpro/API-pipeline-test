<?php

namespace App\Domain\Entity;

use App\Infrastructure\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LanguageRepository::class)]
class Language
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 15)]
    private ?string $version = null;

    /**
     * @var Collection<int, Framework>
     */
    #[ORM\OneToMany(targetEntity: Framework::class, mappedBy: 'language')]
    private Collection $frameworks;

    public function __construct()
    {
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

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): static
    {
        $this->version = $version;

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
            $framework->setLanguage($this);
        }

        return $this;
    }

    public function removeFramework(Framework $framework): static
    {
        if ($this->frameworks->removeElement($framework)) {
            // set the owning side to null (unless already changed)
            if ($framework->getLanguage() === $this) {
                $framework->setLanguage(null);
            }
        }

        return $this;
    }
}
