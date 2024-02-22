<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
   

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'text')]
    private ?string $contenu = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\ManyToOne(targetEntity: Investissement::class, inversedBy: 'commentaires')]
    private ?Investissement $investissement = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $nomuser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getInvestissement(): ?Investissement
    {
        return $this->investissement;
    }

    public function setInvestissement(?Investissement $investissement): self
    {
        $this->investissement = $investissement;

        return $this;
    }
    public function getNomuser(): ?string
    {
        return $this->nomuser;
    }

    public function setNomuser(?string $nomuser): self
    {
        $this->nomuser = $nomuser;

        return $this;
    }
}