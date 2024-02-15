<?php

namespace App\Entity;

use App\Repository\StagiaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StagiaireRepository::class)]
class Stagiaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'idStagiare')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stage $idStage = null;

    #[ORM\ManyToOne(inversedBy: 'stagiaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employee $encadrant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdStage(): ?Stage
    {
        return $this->idStage;
    }

    public function setIdStage(?Stage $idStage): static
    {
        $this->idStage = $idStage;

        return $this;
    }

    public function getEncadrant(): ?Employee
    {
        return $this->encadrant;
    }

    public function setEncadrant(?Employee $encadrant): static
    {
        $this->encadrant = $encadrant;

        return $this;
    }
    public function __toString(){
        return (String)$this->getId();
    }
    
}
