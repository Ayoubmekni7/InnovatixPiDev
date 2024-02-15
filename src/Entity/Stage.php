<?php

namespace App\Entity;

use App\Repository\StageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: StageRepository::class)]
class Stage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Veuillez entrer le sujet')]
    private ?string $sujet = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Veuillez entrer la date du stage')]
    private ?\DateInterval $dateDebut = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): static
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getDateDebut(): ?\DateInterval
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateInterval $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }
}
