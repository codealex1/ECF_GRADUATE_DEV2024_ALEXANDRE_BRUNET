<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TIME_MUTABLE,nullable: true)]
    private ?\DateTimeInterface $heure_ouverture = null;

    #[ORM\Column(type: Types::TIME_MUTABLE,nullable: true)]
    private ?\DateTimeInterface $heure_fermeture = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getHeureOuverture(): ?\DateTimeInterface
    {
        return $this->heure_ouverture;
    }

    public function setHeureOuverture(\DateTimeInterface $heure_ouverture ): static
    {
        $this->heure_ouverture = $heure_ouverture;

        return $this;
    }

    public function getHeureFermeture(): ?\DateTimeInterface
    {
        return $this->heure_fermeture;
    }

    public function setHeureFermeture(\DateTimeInterface $heure_fermeture): static
    {
        $this->heure_fermeture = $heure_fermeture;

        return $this;
    }
}
