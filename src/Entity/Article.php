<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomAutArt = null;

    #[ORM\Column(length: 255)]
    private ?string $adrAutArt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datePubArt = null;

    #[ORM\Column]
    private ?int $dureeArt = null;

    #[ORM\Column(length: 255)]
    private ?string $categorieArt = null;

    #[ORM\Column(length: 255)]
    private ?string $titreArt = null;

    #[ORM\Column(length: 255)]
    private ?string $contenuArt = null;

    #[ORM\Column(length: 255)]
    private ?string $piecejointeArt = null;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: Commentaire::class)]
    private Collection $commentaire;


    public function __construct()
    {
        $this->commentaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAutArt(): ?string
    {
        return $this->nomAutArt;
    }

    public function setNomAutArt(?string $nomAutArt): self
    {
        $this->nomAutArt = $nomAutArt;

        return $this;
    }

    public function getAdrAutArt(): ?string
    {
        return $this->adrAutArt;
    }

    public function setAdrAutArt(?string $adrAutArt): self
    {
        $this->adrAutArt = $adrAutArt;

        return $this;
    }

    public function getDatePubArt(): ?\DateTimeInterface
    {
        return $this->datePubArt;
    }

    public function setDatePubArt(?\DateTimeInterface $datePubArt): self
    {
        $this->datePubArt = $datePubArt;

        return $this;
    }

    public function getDureeArt(): ?int
    {
        return $this->dureeArt;
    }

    public function setDureeArt(?int $dureeArt): self
    {
        $this->dureeArt = $dureeArt;

        return $this;
    }

    public function getCategorieArt(): ?string
    {
        return $this->categorieArt;
    }

    public function setCategorieArt(?string $categorieArt): self
    {
        $this->categorieArt = $categorieArt;

        return $this;
    }

    public function getTitreArt(): ?string
    {
        return $this->titreArt;
    }

    public function setTitreArt(?string $titreArt): self
    {
        $this->titreArt = $titreArt;

        return $this;
    }

    public function getContenuArt(): ?string
    {
        return $this->contenuArt;
    }

    public function setContenuArt(?string $contenuArt): self
    {
        $this->contenuArt = $contenuArt;

        return $this;
    }

    public function getPiecejointeArt(): ?string
    {
        return $this->piecejointeArt;
    }

    public function setPiecejointeArt(?string $piecejointeArt): self
    {
        $this->piecejointeArt = $piecejointeArt;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaire(): Collection
    {
        return $this->commentaire;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaire->contains($commentaire)) {
            $this->commentaire->add($commentaire);
            $commentaire->setArticle($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaire->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getArticle() === $this) {
                $commentaire->setArticle(null);
            }
        }

        return $this;
    }

   
}