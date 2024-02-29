<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $user = null;



    #[Assert\NotBlank(message: "saisir le nom de projet")]
    #[Assert\Length(
        min: 3,
        minMessage: 'Votre nom doit contenir au moins {{ limit }} caractères.'
    )]
    #[Assert\Regex(
        pattern: '/^[A-Z][a-zA-Z]*$/',
        message: "Votre nom doit commencer par une lettre majuscule."
    )]
    #[ORM\Column(length: 100)]
    private ?string $nomprojet = null;




    #[Assert\NotBlank(message: "saisir la catégorie")]
    #[Assert\Length(
        min: 3,
        minMessage: 'Votre categorie doit contenir au moins {{ limit }} caractères.'
    )]
    #[ORM\Column(length: 100)]
    private ?string $categorie = null;



  #[Assert\Length(
        min: 3,
        minMessage: 'Votre description doit contenir au moins {{ limit }} caractères.'
    )]
    #[Assert\NotBlank(message: "saisir la description du projet")]
    #[ORM\Column(length: 100)]
    private ?string $descriptionprojet = null;



    #[Assert\NotBlank(message: "saisir le budget du projet")]
    #[ORM\Column]
    private ?float $budgetprojet = null;




    #[Assert\NotBlank(message: "saisir la date de création du projet")]
    #[Assert\EqualTo("today", message:"La date doit être la date d'aujourd'hui.")]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datecreation = null;


    #[Assert\GreaterThanOrEqual(
        value: 1,
        message: "La durée doit être supérieure ou égale à 1."
    )]
    #[Assert\NotBlank(message: "saisir la durée du projet")]
    #[ORM\Column]
    private ?int $dureeprojet = null;

    #[Assert\NotBlank(message: "saisir le statut du projet")]
    #[ORM\Column]
    private ?int $statutprojet = null;

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
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
