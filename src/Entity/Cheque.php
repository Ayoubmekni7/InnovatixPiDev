<?php

namespace App\Entity;

use App\Repository\ChequeRepository;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Expr\Cast\Double;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: ChequeRepository::class)]
class Cheque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\Length(min: 13, max: 24, exactMessage: 'Le numéro de compte doit contenir 24 chiffres ou les 13 dernier chiffres ')]
    private ?int  $numeroCompte = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez saisir le nom de Titulaire ')]
    private ?string $titulaireCompte = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez choisir un Type de Bénéficiare ')]
    private ?string $Beneficiaire = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez saisir le nom de Bénéficiare ')]
    private ?string $NomBeneficiaire = null;

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
    private ?string $Email = null;

    #[ORM\ManyToOne(inversedBy: 'idCheque')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Compte $compte = null;

    #[ORM\Column]
    private ?int $Cin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCompte(): ?int
    {
        return $this->numeroCompte;
    }

    public function setNumeroCompte(int $numeroCompte): static
    {
        $this->numeroCompte = $numeroCompte;

        return $this;
    }

    public function getTitulaireCompte(): ?string
    {
        return $this->titulaireCompte;
    }

    public function setTitulaireCompte(string $titulaireCompte): static
    {
        $this->titulaireCompte = $titulaireCompte;

        return $this;
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

    public function getNomBeneficiaire(): ?string
    {
        return $this->NomBeneficiaire;
    }

    public function setNomBeneficiaire(string $NomBeneficiaire): static
    {
        $this->NomBeneficiaire = $NomBeneficiaire;

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

}
