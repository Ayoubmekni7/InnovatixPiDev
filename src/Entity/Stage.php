<?php

namespace App\Entity;

use App\Repository\StageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: StageRepository::class)]
class Stage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Veuillez entrer le sujet')]
    private ?string $sujet = null;
    
    #[ORM\Column( nullable: true)]
    #[Assert\NotBlank(message: 'Veuillez choisir la date du stage')]
    private ?\DateInterval $date = null;

    #[ORM\OneToMany(mappedBy: 'idStage', targetEntity: Stagiaire::class, orphanRemoval: true)]
    #[Assert\NotBlank(message: 'Veuillez entrer le stagiaire')]
    private Collection $idStagiare;

    public function __construct()
    {
        $this->idStagiare = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): static
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getDate(): ?\DateInterval
    {
        return $this->date;
    }

    public function setDate(\DateInterval $date): static
    {
        $this->date = $date;

        return $this;
    }
    
    /**
     * @return Collection<int, Stagiaire>
     */
    public function getIdStagiare(): Collection
    {
        return $this->idStagiare;
    }

    public function addIdStagiare(Stagiaire $idStagiare): static
    {
        if (!$this->idStagiare->contains($idStagiare)) {
            $this->idStagiare->add($idStagiare);
            $idStagiare->setIdStage($this);
        }

        return $this;
    }
    
    public function removeIdStagiare(Stagiaire $idStagiare): static
    {
        if ($this->idStagiare->removeElement($idStagiare)) {
            // set the owning side to null (unless already changed)
            if ($idStagiare->getIdStage() === $this) {
                $idStagiare->setIdStage(null);
            }
        }

        return $this;
    }
    
    public function __toString(): string
    {
       
        return (String)$this->getIdStagiare();
    }
    
}
