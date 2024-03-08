<?php

namespace App\Entity;
use Doctrine\Common\Collections\Collection;

use App\Repository\InvestissementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvestissementRepository::class)]
class Investissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $user = null;
    
    #[Assert\NotBlank(message: "Veuillez saisir un nom.")]
    #[ORM\Column(length: 255)]
    private ?string $nom = null;
    
    #[Assert\NotBlank(message: "Veuillez saisir un montant.")]
    #[ORM\Column(type: 'integer')]
    private ?int $montant = null;
    
    #[Assert\NotBlank(message: "Veuillez saisir une date d'investissement.")]
    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $dateInvestissement = null;
    
    #[Assert\NotBlank(message: "Veuillez saisir une description.")]
    #[ORM\Column(type: 'text')]
    private ?string $description = null;
    
    #[Assert\NotBlank(message: "Veuillez saisir un type d'investissement.")]
    #[ORM\Column(length: 255)]
    private ?string $typeInvestissement = null;
    
    #[Assert\NotBlank(message: "Veuillez saisir une durée.")]
    #[ORM\Column(type: 'integer')]
    private ?int $duree = null;
    
    #[Assert\NotBlank(message: "Veuillez saisir un taux de rendement.")]
    #[ORM\Column(type: 'integer')]
    private ?int $tauxRendement = null;
    
    #[Assert\NotBlank(message: "Veuillez saisir un statut.")]
    #[ORM\Column(length: 50)]
    private ?string $statut = null;
    
    #[ORM\Column(type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $createdAt = null;
    
    #[ORM\OneToOne(targetEntity: Project::class, cascade: ["remove"])]
    #[ORM\JoinColumn(name: 'project_id', referencedColumnName: 'id')]
    private ?Project $project = null;
    
    #[ORM\Column(type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP', 'onUpdate' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $updatedAt = null;
    
    #[ORM\OneToMany(mappedBy: 'investissement', targetEntity: Commentaire::class, cascade: ['remove'])]
    private Collection $commentaires;
    
    #[ORM\OneToMany(mappedBy: 'investissement', targetEntity: Evenement::class, cascade: ['remove'])]
    private Collection $evenements;
    
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
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }
    
    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setInvestissement($this);
        }
        
        return $this;
    }
    
    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getInvestissement() === $this) {
                $commentaire->setInvestissement(null);
            }
        }
        
        return $this;
    }
    
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }
    
    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements[] = $evenement;
            $evenement->setInvestissement($this);
        }
        
        return $this;
    }
    
    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->removeElement($evenement)) {
            // set the owning side to null (unless already changed)
            if ($evenement->getInvestissement() === $this) {
                $evenement->setInvestissement(null);
            }
        }
        
        return $this;
    }
    
    public function getProject(): ?Project
    {
        return $this->project;
    }
    
    public function setProject(?Project $project): self
    {
        $this->project = $project;
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