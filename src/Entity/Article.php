<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idArt = null;

    #[ORM\Column(length: 255)]
    private ?string $titreArt = null;

    #[ORM\Column(length: 255)]
    private ?string $contenuArt = null;

    #[ORM\Column(length: 255)]
    private ?string $auteurArt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datePubArt = null;

    #[ORM\Column]
    private ?int $dureeArt = null;

    #[ORM\Column(length: 255)]
    private ?string $statutArt = null;

    #[ORM\Column(length: 255)]
    private ?string $categArt = null;

    #[ORM\OneToMany(mappedBy: 'idArt', targetEntity: Commentaire::class, orphanRemoval: true)]
    private Collection $idComArt;

    public function __construct()
    {
        $this->idComArt = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreArt(): ?string
    {
        return $this->titreArt;
    }

    public function setTitreArt(string $titreArt): static
    {
        $this->titreArt = $titreArt;

        return $this;
    }

    public function getContenuArt(): ?string
    {
        return $this->contenuArt;
    }

    public function setContenuArt(string $contenuArt): static
    {
        $this->contenuArt = $contenuArt;

        return $this;
    }

    public function getAuteurArt(): ?string
    {
        return $this->auteurArt;
    }

    public function setAuteurArt(string $auteurArt): static
    {
        $this->auteurArt = $auteurArt;

        return $this;
    }

    public function getDatePubArt(): ?\DateTimeInterface
    {
        return $this->datePubArt;
    }

    public function setDatePubArt(\DateTimeInterface $datePubArt): static
    {
        $this->datePubArt = $datePubArt;

        return $this;
    }

    public function getDureeArt(): ?int
    {
        return $this->dureeArt;
    }

    public function setDureeArt(int $dureeArt): static
    {
        $this->dureeArt = $dureeArt;

        return $this;
    }

    public function getStatutArt(): ?string
    {
        return $this->statutArt;
    }

    public function setStatutArt(string $statutArt): static
    {
        $this->statutArt = $statutArt;

        return $this;
    }

    public function getCategArt(): ?string
    {
        return $this->categArt;
    }

    public function setCategArt(string $categArt): static
    {
        $this->categArt = $categArt;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getIdComArt(): Collection
    {
        return $this->idComArt;
    }

    public function addIdComArt(Commentaire $idComArt): static
    {
        if (!$this->idComArt->contains($idComArt)) {
            $this->idComArt->add($idComArt);
            $idComArt->setIdArt($this);
        }

        return $this;
    }

    public function removeIdComArt(Commentaire $idComArt): static
    {
        if ($this->idComArt->removeElement($idComArt)) {
            // set the owning side to null (unless already changed)
            if ($idComArt->getIdArt() === $this) {
                $idComArt->setIdArt(null);
            }
        }

        return $this;
    }
}
