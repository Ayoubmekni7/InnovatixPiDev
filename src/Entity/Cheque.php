<?php

namespace App\Entity;

use App\Repository\ChequeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: ChequeRepository::class)]
class Cheque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez choisir un Type de Bénéficiare ')]
    private ?string $Beneficiaire = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Veuillez saisir le montant')]
    private ?float $Montant = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Veuillez saisir votre numéro de téléphone')]
    #[Assert\Length(min: 8, max: 8, exactMessage: 'Le numéro de téléphone doit contenir 8 chiffres')]
    #[Assert\Regex(pattern: '/^(2|5|9)[0-9]{7}$/', message: 'Le numéro de téléphone doit commencer par 2 ou 5 ou 9 et contenir 8 chiffres')]
    private ?int $telephone = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Email obligatoire')]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/",
        message: "L'adresse email '{{ value }}' n'est pas valide."
    )]
    private ?string $Email = null;

    #[ORM\ManyToOne(inversedBy: 'idCheque')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Compte $compte = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Veuillez saisir numéro de votre cin')]
    #[Assert\Length(min: 8, max: 8, exactMessage: 'Le numéro de cin doit contenir 8 chiffres')]
    #[Assert\Regex(pattern: '/^(1|0)[0-9]{7}$/', message: 'Le numéro de cin doit commencer par 1 ou 0 et contenir 8 chiffres')]
    private ?int $Cin = null;



    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez saisir votre nom et prenom')]
    private ?string $NomPrenom = null;



    public function getId(): ?int
    {
        return $this->id;
    }
    public function getBeneficiaire(): ?string
    {
        return $this->Beneficiaire;
    }

    public function setBeneficiaire(string $Beneficiaire): static
    {
        $this->Beneficiaire = $Beneficiaire;

        return $this;
    }
    public function getMontant(): ?float
    {
        return $this->Montant;
    }

    public function setMontant(float $Montant): static
    {
        $this->Montant = $Montant;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): static
    {
        $this->Email = $Email;

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

    public function getNometprenom(): ?string
    {
        return $this->nometprenom;
    }

    public function setNometprenom(string $nometprenom): static
    {
        $this->nometprenom = $nometprenom;

        return $this;
    }

    public function getNomPrenom(): ?string
    {
        return $this->NomPrenom;
    }

    public function setNomPrenom(string $NomPrenom): static
    {
        $this->NomPrenom = $NomPrenom;

        return $this;
    }

}
