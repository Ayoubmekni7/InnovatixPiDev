<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\ManyToMany(targetEntity: Stage::class, inversedBy: 'users',orphanRemoval: true)]
    private Collection $stage;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: OffreStage::class)]
    private Collection $offreStages;
    
    public function __construct()
    {
        $this->stage = new ArrayCollection();
        $this->offreStages = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }
  
 
    
    
    /**
     * @return Collection<int, Stage>
     */
    public function getStage(): Collection
    {
        return $this->stage;
    }
    
    public function addStage(Stage $stage): static
    {
        if (!$this->stage->contains($stage)) {
            $this->stage->add($stage);
        }
        
        return $this;
    }
    
    public function removeStage(Stage $stage): static
    {
        $this->stage->removeElement($stage);
        
        return $this;
    }
    public  function __toString() : String {
        return (String)$this->getId();
    }

    /**
     * @return Collection<int, OffreStage>
     */
    public function getOffreStages(): Collection
    {
        return $this->offreStages;
    }

    public function addOffreStage(OffreStage $offreStage): static
    {
        if (!$this->offreStages->contains($offreStage)) {
            $this->offreStages->add($offreStage);
            $offreStage->setUser($this);
        }

        return $this;
    }

    public function removeOffreStage(OffreStage $offreStage): static
    {
        if ($this->offreStages->removeElement($offreStage)) {
            // set the owning side to null (unless already changed)
            if ($offreStage->getUser() === $this) {
                $offreStage->setUser(null);
            }
        }

        return $this;
    }
}
