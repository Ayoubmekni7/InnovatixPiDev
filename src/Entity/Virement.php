<?php

namespace App\Entity;

use App\Repository\VirementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VirementRepository::class)]
class Virement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;



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

    #[ORM\Column(nullable: true)]
    #[Assert\Length(min: 13, max: 24, exactMessage: 'Le numéro de rib doit contenir 24 chiffres ou les 13 dernier chiffres ')]
    private ?int $RIB = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'Email obligatoire')]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/",
        message: "L'adresse email '{{ value }}' n'est pas valide."
    )]
    private ?string $Email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $DecisionV = null;

    #[ORM\ManyToOne(inversedBy: 'virements')]
    private ?User $user = null;

    #[ORM\Column(nullable: true)]
    private ?int $ActionsV = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRIB(): ?int
    {
        return $this->RIB;
    }

    public function setRIB(int $RIB): static
    {
        $this->RIB = $RIB;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(?string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    public function getDecisionV(): ?string
    {
        return $this->DecisionV;
    }

    public function setDecisionV(?string $DecisionV): static
    {
        $this->DecisionV = $DecisionV;

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

    public function getActionsV(): ?int
    {
        return $this->ActionsV;
    }

    public function setActionsV(?int $ActionsV): static
    {
        $this->ActionsV = $ActionsV;

        return $this;
    }
}
