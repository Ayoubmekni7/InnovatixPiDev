<?php

namespace App\Entity;

use App\Repository\OffreStageRepository;
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

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $niveau = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $language = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $exigenceOffre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datePostu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $motsCles = null;

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

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(?string $niveau): static
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): static
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

    public function getMotsCles(): ?string
    {
        return $this->motsCles;
    }

    public function setMotsCles(?string $motsCles): static
    {
        $this->motsCles = $motsCles;

        return $this;
    }
}
