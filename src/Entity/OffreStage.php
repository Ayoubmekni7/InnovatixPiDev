<?php

namespace App\Entity;

use App\Repository\OffreStageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffreStageRepository::class)]
class OffreStage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80)]
    private ?string $title = null;

    #[ORM\Column(length: 50)]
    private ?string $domaine = null;

    #[ORM\Column(length: 30)]
    private ?string $typeOffre = null;

    #[ORM\Column]
    private ?int $postePropose = null;

    #[ORM\Column(nullable: true)]
    private ?int $experience = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $niveau = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $language = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $exigenceOffre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datePostu = null;

    #[ORM\Column(type: "json", nullable: true)]
    private ?array  $motsCles = null;
    

    #[ORM\OneToMany(mappedBy: 'offreStage', targetEntity: Demandestage::class)]
    private Collection $demande;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pfeBook = null;

    public function __construct()
    {
        $this->demande = new ArrayCollection();
        $this->motsCles = [];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(string $domaine): static
    {
        $this->domaine = $domaine;

        return $this;
    }

    public function getTypeOffre(): ?string
    {
        return $this->typeOffre;
    }

    public function setTypeOffre(string $typeOffre): static
    {
        $this->typeOffre = $typeOffre;

        return $this;
    }

    public function getPostePropose(): ?int
    {
        return $this->postePropose;
    }

    public function setPostePropose(int $postePropose): static
    {
        $this->postePropose = $postePropose;

        return $this;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(?int $experience): static
    {
        $this->experience = $experience;

        return $this;
    }

    public function getNiveau(): ?array
    {
        return $this->niveau;
    }

    public function setNiveau(?array $niveau): static
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getLanguage(): ?array
    {
        return $this->language;
    }

    public function setLanguage(?array $language): static
    {
        $this->language = $language;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getExigenceOffre(): ?string
    {
        return $this->exigenceOffre;
    }

    public function setExigenceOffre(string $exigenceOffre): static
    {
        $this->exigenceOffre = $exigenceOffre;

        return $this;
    }

    public function getDatePostu(): ?\DateTimeInterface
    {
        return $this->datePostu;
    }

    public function setDatePostu(?\DateTimeInterface $datePostu): static
    {
        $this->datePostu = $datePostu;

        return $this;
    }

    public function getMotsCles(): array
    {
        return $this->motsCles ?? [];
    }

    public function setMotsCles(?array $motsCles): static
    {
        $this->motsCles = $motsCles;

        return $this;
    }

    /**
     * @return Collection<int, Demandestage>
     */
    public function getDemande(): Collection
    {
        return $this->demande;
    }

    public function addDemande(Demandestage $demande): static
    {
        if (!$this->demande->contains($demande)) {
            $this->demande->add($demande);
            $demande->setOffreStage($this);
        }

        return $this;
    }

    public function removeDemande(Demandestage $demande): static
    {
        if ($this->demande->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getOffreStage() === $this) {
                $demande->setOffreStage(null);
            }
        }

        return $this;
    }

    public function getPfeBook(): ?string
    {
        return $this->pfeBook;
    }

    public function setPfeBook(?string $pfeBook): static
    {
        $this->pfeBook = $pfeBook;

        return $this;
    }
    public  function  __toString(): string
    {
        return (String)$this->getId();
    }
    
}
