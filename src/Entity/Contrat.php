<?php

namespace App\Entity;

use App\Repository\ContratRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContratRepository::class)]
class Contrat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[Assert\NotBlank(message: 'Veuillez coisir le stagiaire')]
    private ?Stagiaire $stagiare = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'Veuillez saisir la date de début du stage')]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Veuillez saisir la durée du stage')]
    private ?int $dure = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'Veuillez saisir la date de fin du stage')]
    private ?\DateTimeInterface $datefin = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Veuillez saisir le sujet de stage')]
    private ?string $sujet = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStagiare(): ?Stagiaire
    {
        return $this->stagiare;
    }

    public function setStagiare(?Stagiaire $stagiare): static
    {
        $this->stagiare = $stagiare;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDure(): ?int
    {
        return $this->dure;
    }

    public function setDure(int $dure): static
    {
        $this->dure = $dure;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(\DateTimeInterface $datefin): static
    {
        $this->datefin = $datefin;

        return $this;
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
    public function __toString(){
        return (String)$this->getId();
    }
}
