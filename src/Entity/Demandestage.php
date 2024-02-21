<?php

namespace App\Entity;

use App\Repository\DemandeStageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: DemandeStageRepository::class)]
class Demandestage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: 'Veuillez saisir votre nom')]

    private ?string $nom = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: 'Veuillez saisir votre prenom')]
    private ?string $prenom = null;

    #[ORM\Column(length: 40)]
    #[Assert\NotBlank(message: 'Email obligatoire')]
    private ?string $email = null;
    #[ORM\Column]
    #[Assert\NotBlank(message: 'Veuillez saisir votre numéro de téléphone')]
    #[Assert\Length(min: 8, max: 8, exactMessage: 'Le numéro de téléphone doit contenir 8 chiffres')]
    #[Assert\Regex(pattern: '/^(2|5|9)[0-9]{7}$/', message: 'Le numéro de téléphone doit commencer par 2 ou 5 ou 9 et contenir 8 chiffres')]
    private ?int $numerotelephone = null;
    
    
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank(message: 'Veuillez saisir une lettre de motivation')]
    private ?string $lettremotivation = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\NotBlank(message: 'Veuillez entrer votre CV en pdf ')]
    private ?string $cv = null;
    
    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\NotBlank(message: 'Veuillez choisir un domaine')]
    private ?string $domaine = null;

    #[ORM\Column( type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'Veuillez choisir la date du stage')]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\ManyToOne(inversedBy: 'demande')]
    private ?OffreStage $offreStage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getNumerotelephone(): ?int
    {
        return $this->numerotelephone;
    }

    public function setNumerotelephone(int $numerotelephone): static
    {
        $this->numerotelephone = $numerotelephone;

        return $this;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(?string $cv): static
    {
        $this->cv = $cv;

        return $this;
    }

    public function getLettremotivation(): ?string
    {
        return $this->lettremotivation;
    }

    public function setLettremotivation(?string $lettremotivation): static
    {
        $this->lettremotivation = $lettremotivation;

        return $this;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(?string $domaine): static
    {
        $this->domaine = $domaine;

        return $this;
    }

    public function getDate(): ?\DateInterval
    {
        return $this->date;
    }

    public function setDate(\DateInterval $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getOffreStage(): ?OffreStage
    {
        return $this->offreStage;
    }

    public function setOffreStage(?OffreStage $offreStage): static
    {
        $this->offreStage = $offreStage;

        return $this;
    }
}
