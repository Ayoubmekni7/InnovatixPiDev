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

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Virement::class)]
    private Collection $virements;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Cheque::class)]
    private Collection $cheque;

    #[ORM\ManyToMany(targetEntity: Compte::class, inversedBy: 'users')]
    private Collection $compte;

    public function __construct()
    {
        $this->virements = new ArrayCollection();
        $this->cheque = new ArrayCollection();
        $this->compte = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Virement>
     */
    public function getVirements(): Collection
    {
        return $this->virements;
    }

    public function addVirement(Virement $virement): static
    {
        if (!$this->virements->contains($virement)) {
            $this->virements->add($virement);
            $virement->setUser($this);
        }

        return $this;
    }

    public function removeVirement(Virement $virement): static
    {
        if ($this->virements->removeElement($virement)) {
            // set the owning side to null (unless already changed)
            if ($virement->getUser() === $this) {
                $virement->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Cheque>
     */
    public function getCheque(): Collection
    {
        return $this->cheque;
    }

    public function addCheque(Cheque $cheque): static
    {
        if (!$this->cheque->contains($cheque)) {
            $this->cheque->add($cheque);
            $cheque->setUser($this);
        }

        return $this;
    }

    public function removeCheque(Cheque $cheque): static
    {
        if ($this->cheque->removeElement($cheque)) {
            // set the owning side to null (unless already changed)
            if ($cheque->getUser() === $this) {
                $cheque->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Compte>
     */
    public function getCompte(): Collection
    {
        return $this->compte;
    }

    public function addCompte(Compte $compte): static
    {
        if (!$this->compte->contains($compte)) {
            $this->compte->add($compte);
        }

        return $this;
    }

    public function removeCompte(Compte $compte): static
    {
        $this->compte->removeElement($compte);

        return $this;
    }
}
