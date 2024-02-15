<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nomprojet = null;

    #[ORM\Column(length: 100)]
    private ?string $categorie = null;

    #[ORM\Column(length: 100)]
    private ?string $descriptionprojet = null;

    #[ORM\Column]
    private ?float $budgetprojet = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datecreation = null;

    #[ORM\Column]
    private ?int $dureeprojet = null;

    #[ORM\Column(length: 100)]
    private ?string $statutprojet = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProjet(): ?string
    {
        return $this->nomprojet;
    }

    public function setNomProjet(string $nomprojet): static
    {
        $this->nomprojet = $nomprojet;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getDescriptionProjet(): ?string
    {
        return $this->descriptionprojet;
    }

    public function setDescriptionProjet(string $descriptionprojet): static
    {
        $this->descriptionprojet = $descriptionprojet;

        return $this;
    }

    public function getBudgetProjet(): ?float
    {
        return $this->budgetprojet;
    }

    public function setBudgetProjet(float $budgetprojet): static
    {
        $this->budgetprojet = $budgetprojet;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->datecreation;
    }

    public function setDateCreation(\DateTimeInterface $datecreation): static
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    public function getDureeProjet(): ?int
    {
        return $this->dureeprojet;
    }

    public function setDureeProjet(int $dureeprojet): static
    {
        $this->dureeprojet = $dureeprojet;

        return $this;
    }

    public function getStatutProjet(): ?string
    {
        return $this->statutprojet;
    }

    public function setStatutProjet(string $statutprojet): static
    {
        $this->statutprojet = $statutprojet;

        return $this;
    }
}
