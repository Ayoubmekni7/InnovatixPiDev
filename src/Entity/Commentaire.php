<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomAutCom = null;

    #[ORM\Column(length: 255)]
    private ?string $adrAutCom = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datePubCom = null;

    #[ORM\Column(length: 255)]
    private ?string $contenuCom = null;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAutCom(): ?string
    {
        return $this->nomAutCom;
    }

    public function setNomAutCom(string $nomAutCom): static
    {
        $this->nomAutCom = $nomAutCom;

        return $this;
    }

    public function getAdrAutCom(): ?string
    {
        return $this->adrAutCom;
    }

    public function setAdrAutCom(string $adrAutCom): static
    {
        $this->adrAutCom = $adrAutCom;

        return $this;
    }

    public function getDatePubCom(): ?\DateTimeInterface
    {
        return $this->datePubCom;
    }

    public function setDatePubCom(\DateTimeInterface $datePubCom): static
    {
        $this->datePubCom = $datePubCom;

        return $this;
    }

    public function getContenuCom(): ?string
    {
        return $this->contenuCom;
    }

    public function setContenuCom(string $contenuCom): static
    {
        $this->contenuCom = $contenuCom;

        return $this;
    }
}
