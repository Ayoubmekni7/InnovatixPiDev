<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $objetRec = null;

    #[ORM\Column(length: 255)]
    private ?string $contenuRec = null;

    #[ORM\Column(length: 255)]
    private ?string $adrRec = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE , nullable:true)]
    private ?\DateTimeInterface $dateRec = null;

    #[ORM\Column(length: 255)]
    private ?string $depRec = null;

    #[ORM\Column(length: 255 , nullable:true)]
    private ?string $statutRec = null;

    #[ORM\OneToMany(mappedBy: 'reclamation', targetEntity: Reponse::class)]
    private Collection $reponses;

    public function __construct()
    {
        $this->reponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjetRec(): ?string
    {
        return $this->objetRec;
    }

    public function setObjetRec(string $objetRec): static
    {
        $this->objetRec = $objetRec;

        return $this;
    }

    public function getContenuRec(): ?string
    {
        return $this->contenuRec;
    }

    public function setContenuRec(string $contenuRec): static
    {
        $this->contenuRec = $contenuRec;

        return $this;
    }

    public function getAdrRec(): ?string
    {
        return $this->adrRec;
    }

    public function setAdrRec(string $adrRec): static
    {
        $this->adrRec = $adrRec;

        return $this;
    }

    public function getDateRec(): ?\DateTimeInterface
    {
        return $this->dateRec;
    }

    public function setDateRec(\DateTimeInterface $dateRec): static
    {
        $this->dateRec = $dateRec;

        return $this;
    }

    public function getDepRec(): ?string
    {
        return $this->depRec;
    }

    public function setDepRec(string $depRec): static
    {
        $this->depRec = $depRec;

        return $this;
    }

    public function getStatutRec(): ?string
    {
        return $this->statutRec;
    }

    public function setStatutRec(string $statutRec): static
    {
        $this->statutRec = $statutRec;

        return $this;
    }

    /**
     * @return Collection<int, Reponse>
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): static
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses->add($reponse);
            $reponse->setReclamation($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): static
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getReclamation() === $this) {
                $reponse->setReclamation(null);
            }
        }

        return $this;
    }
}
