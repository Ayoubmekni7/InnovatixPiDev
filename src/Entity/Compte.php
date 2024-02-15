<?php

namespace App\Entity;

use App\Repository\CompteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompteRepository::class)]
class Compte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Email = null;

    #[ORM\Column(length: 255)]
    private ?string $confirmationEmail = null;

    #[ORM\Column]
    private ?int $cin = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateDelivranceCin = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $sexe = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateNaissance = null;

    #[ORM\Column(length: 255)]
    private ?string $proffesion = null;

    #[ORM\Column(length: 255)]
    private ?string $typeCompte = null;

    #[ORM\Column]
    private ?float $Montant = null;

    #[ORM\OneToMany(mappedBy: 'compte', targetEntity: Cheque::class, orphanRemoval: true)]
    private Collection $idCheque;

    #[ORM\OneToMany(mappedBy: 'compte', targetEntity: Virement::class, orphanRemoval: true)]
    private Collection $idVirement;

    public function __construct()
    {
        $this->idCheque = new ArrayCollection();
        $this->idVirement = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
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

    public function getConfirmationEmail(): ?string
    {
        return $this->confirmationEmail;
    }

    public function setConfirmationEmail(string $confirmationEmail): static
    {
        $this->confirmationEmail = $confirmationEmail;

        return $this;
    }

    public function getCin(): ?int
    {
        return $this->cin;
    }

    public function setCin(int $cin): static
    {
        $this->cin = $cin;

        return $this;
    }

    public function getDateDelivranceCin(): ?\DateTimeInterface
    {
        return $this->DateDelivranceCin;
    }

    public function setDateDelivranceCin(\DateTimeInterface $DateDelivranceCin): static
    {
        $this->DateDelivranceCin = $DateDelivranceCin;

        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->DateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $DateNaissance): static
    {
        $this->DateNaissance = $DateNaissance;

        return $this;
    }

    public function getProffesion(): ?string
    {
        return $this->proffesion;
    }

    public function setProffesion(string $proffesion): static
    {
        $this->proffesion = $proffesion;

        return $this;
    }

    public function getTypeCompte(): ?string
    {
        return $this->typeCompte;
    }

    public function setTypeCompte(string $typeCompte): static
    {
        $this->typeCompte = $typeCompte;

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

    /**
     * @return Collection<int, Cheque>
     */
    public function getIdCheque(): Collection
    {
        return $this->idCheque;
    }

    public function addIdCheque(Cheque $idCheque): static
    {
        if (!$this->idCheque->contains($idCheque)) {
            $this->idCheque->add($idCheque);
            $idCheque->setCompte($this);
        }

        return $this;
    }

    public function removeIdCheque(Cheque $idCheque): static
    {
        if ($this->idCheque->removeElement($idCheque)) {
            // set the owning side to null (unless already changed)
            if ($idCheque->getCompte() === $this) {
                $idCheque->setCompte(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Virement>
     */
    public function getIdVirement(): Collection
    {
        return $this->idVirement;
    }

    public function addIdVirement(Virement $idVirement): static
    {
        if (!$this->idVirement->contains($idVirement)) {
            $this->idVirement->add($idVirement);
            $idVirement->setCompte($this);
        }

        return $this;
    }

    public function removeIdVirement(Virement $idVirement): static
    {
        if ($this->idVirement->removeElement($idVirement)) {
            // set the owning side to null (unless already changed)
            if ($idVirement->getCompte() === $this) {
                $idVirement->setCompte(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return (String)$this->getCin();
    }



}
