<?php

namespace App\Entity;

use App\Repository\InvestissementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvestissementRepository::class)]
class Investissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $montant = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $dateInvestissement = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $typeInvestissement = null;

    #[ORM\Column(type: 'integer')]
    private ?int $duree = null;

    #[ORM\Column(type: 'decimal', precision: 5, scale: 2)]
    private ?float $tauxRendement = null;

    #[ORM\Column(length: 50)]
    private ?string $statut = null;

    #[ORM\Column(type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP', 'onUpdate' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getNom(): ?string
    {
        return $this->nom;
    }
    
    public function setNom(?string $nom): self
    {
        $this->nom = $nom;
    
        return $this;
    }
    
    public function getMontant(): ?float
    {
        return $this->montant;
    }
    
    public function setMontant(?float $montant): self
    {
        $this->montant = $montant;
    
        return $this;
    }
    
    public function getDateInvestissement(): ?\DateTimeInterface
    {
        return $this->dateInvestissement;
    }
    
    public function setDateInvestissement(?\DateTimeInterface $dateInvestissement): self
    {
        $this->dateInvestissement = $dateInvestissement;
    
        return $this;
    }
    
    public function getDescription(): ?string
    {
        return $this->description;
    }
    
    public function setDescription(?string $description): self
    {
        $this->description = $description;
    
        return $this;
    }
    
    public function getTypeInvestissement(): ?string
    {
        return $this->typeInvestissement;
    }
    
    public function setTypeInvestissement(?string $typeInvestissement): self
    {
        $this->typeInvestissement = $typeInvestissement;
    
        return $this;
    }
    
    public function getDuree(): ?int
    {
        return $this->duree;
    }
    
    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;
    
        return $this;
    }
    
    public function getTauxRendement(): ?float
    {
        return $this->tauxRendement;
    }
    
    public function setTauxRendement(?float $tauxRendement): self
    {
        $this->tauxRendement = $tauxRendement;
    
        return $this;
    }
    
    public function getStatut(): ?string
    {
        return $this->statut;
    }
    
    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;
    
        return $this;
    }
    
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
    
    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }
    
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }
    
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }
    
}
