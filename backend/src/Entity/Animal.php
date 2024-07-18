<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    #[ORM\ManyToOne(inversedBy: 'animals' )]
    private ?Habitat $habitat_id = null;

    #[ORM\Column(length: 255,nullable: true)]
    private ?string $image = null;

    #[ORM\Column(nullable: true)]
    private ?int $click = null;

    #[ORM\Column(length: 255)]
    private ?string $race = null;

    #[ORM\OneToMany(mappedBy: 'animal_id', targetEntity: RapportVeterinaire::class)]
    
    private Collection $rapportVeterinaires;

    #[ORM\OneToMany(mappedBy: 'animal', targetEntity: Alimentation::class)]
    private Collection $alimentations;
    
    

    

    public function __construct()
    {
        $this->rapports = new ArrayCollection();
        $this->rapportVeterinaires = new ArrayCollection();
        $this->alimentations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getHabitatId(): ?Habitat
    {
        return $this->habitat_id;
    }

    public function setHabitatId(?Habitat $habitat_id): static
    {
        $this->habitat_id = $habitat_id;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getClick(): ?int
    {
        return $this->click;
    }

    public function setClick(?int $click): static
    {
        $this->click = $click;

        return $this;
    }

    public function incrementClick(): self
    {
        $this->click++;

        return $this;
    }

    public function getRace(): ?string
    {
        return $this->race;
    }

    public function setRace(string $race): static
    {
        $this->race = $race;

        return $this;
    }

    /**
     * @return Collection<int, RapportVeterinaire>
     */
    public function getRapportVeterinaires(): Collection
    {
        return $this->rapportVeterinaires;
    }

    /**
     * @return Collection<int, Alimentation>
     */
    public function getAlimentations(): Collection
    {
        return $this->alimentations;
    }

    public function addAlimentation(Alimentation $alimentation): static
    {
        if (!$this->alimentations->contains($alimentation)) {
            $this->alimentations->add($alimentation);
            $alimentation->setAnimal($this);
        }

        return $this;
    }

    public function removeAlimentation(Alimentation $alimentation): static
    {
        if ($this->alimentations->removeElement($alimentation)) {
            // set the owning side to null (unless already changed)
            if ($alimentation->getAnimal() === $this) {
                $alimentation->setAnimal(null);
            }
        }

        return $this;
    }

    

    

    
}
