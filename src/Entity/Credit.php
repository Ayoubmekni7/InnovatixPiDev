<?php

namespace App\Entity;

use App\Repository\CreditRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreditRepository::class)]
class Credit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_client = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\Column(length: 255)]
    private ?string $status_client = null;

    #[ORM\Column]
    private ?float $mensualite = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_debut = null;

    #[ORM\Column]
    private ?int $duree = null;

    #[ORM\Column]
    private ?float $taux = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column]
    private ?float $frais_retard = null;

    #[ORM\OneToMany(mappedBy: 'credit', targetEntity: rdv::class)]
    private Collection $rdv;

    public function __construct()
    {
        $this->rdv = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdClient(): ?int
    {
        return $this->id_client;
    }

    public function setIdClient(int $id_client): static
    {
        $this->id_client = $id_client;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getStatusClient(): ?string
    {
        return $this->status_client;
    }

    public function setStatusClient(string $status_client): static
    {
        $this->status_client = $status_client;

        return $this;
    }

    public function getMensualite(): ?float
    {
        return $this->mensualite;
    }

    public function setMensualite(float $mensualite): static
    {
        $this->mensualite = $mensualite;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getTaux(): ?float
    {
        return $this->taux;
    }

    public function setTaux(float $taux): static
    {
        $this->taux = $taux;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getFraisRetard(): ?float
    {
        return $this->frais_retard;
    }

    public function setFraisRetard(float $frais_retard): static
    {
        $this->frais_retard = $frais_retard;

        return $this;
    }

    /**
     * @return Collection<int, rdv>
     */
    public function getRdv(): Collection
    {
        return $this->rdv;
    }

    public function addRdv(rdv $rdv): static
    {
        if (!$this->rdv->contains($rdv)) {
            $this->rdv->add($rdv);
            $rdv->setCredit($this);
        }

        return $this;
    }

    public function removeRdv(rdv $rdv): static
    {
        if ($this->rdv->removeElement($rdv)) {
            // set the owning side to null (unless already changed)
            if ($rdv->getCredit() === $this) {
                $rdv->setCredit(null);
            }
        }

        return $this;
    }
}
