<?php

namespace App\Entity;

use App\Repository\VirementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VirementRepository::class)]
class Virement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\Length(min: 13, max: 24, exactMessage: 'Le numéro de compte doit contenir 24 chiffres ou les 13 dernier chiffres ')]
    private ?int $numCompte = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez saisir le nom et prenom  ')]
    private ?string $NometPrenom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez choisir un type ')]
    private ?string $TypeVirement = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez saisir le nom de Bénéficiare ')]
    private ?string $transferezA = null;

    #[ORM\Column]
    #[Assert\Length(min: 13, max: 24, exactMessage: 'Le numéro de compte doit contenir 24 chiffres ou les 13 dernier chiffres ')]
    private ?int $NumBeneficiare = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez saisir le montant')]
    private ?string $Montant = null;

    #[ORM\ManyToOne(inversedBy: 'idVirement')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Compte $compte = null;

    #[ORM\Column]
    private ?int $Cin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCompte(): ?int
    {
        return $this->numCompte;
    }

    public function setNumCompte(int $numCompte): static
    {
        $this->numCompte = $numCompte;

        return $this;
    }

    public function getNometPrenom(): ?string
    {
        return $this->NometPrenom;
    }

    public function setNometPrenom(string $NometPrenom): static
    {
        $this->NometPrenom = $NometPrenom;

        return $this;
    }

    public function getTypeVirement(): ?string
    {
        return $this->TypeVirement;
    }

    public function setTypeVirement(string $TypeVirement): static
    {
        $this->TypeVirement = $TypeVirement;

        return $this;
    }

    public function getTransferezA(): ?string
    {
        return $this->transferezA;
    }

    public function setTransferezA(string $transferezA): static
    {
        $this->transferezA = $transferezA;

        return $this;
    }

    public function getNumBeneficiare(): ?int
    {
        return $this->NumBeneficiare;
    }

    public function setNumBeneficiare(int $NumBeneficiare): static
    {
        $this->NumBeneficiare = $NumBeneficiare;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->Montant;
    }

    public function setMontant(string $Montant): static
    {
        $this->Montant = $Montant;

        return $this;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): static
    {
        $this->compte = $compte;

        return $this;
    }
    public function __toString(){
        return (String)$this->getId();
    }

    public function getCin(): ?int
    {
        return $this->Cin;
    }

    public function setCin(int $Cin): static
    {
        $this->Cin = $Cin;

        return $this;
    }
}
