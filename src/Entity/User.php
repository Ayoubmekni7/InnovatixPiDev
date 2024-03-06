<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Project::class)]
    private Collection $projects;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Investissement::class)]
    private Collection $investissements;
    
    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }


    #[Assert\Length(
        min: 8,
        max: 8,
        exactMessage: "Le numéro d'inscription doit contenir exactement 8 chiffres."
    )]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Regex(
        pattern:"^[a-zA-Z0-9._%+-]+@gmail\.com$^",
        message: "adresse email doit se terminer par @gmail.com"
    )]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
   
    #[ORM\Column]
    #[Assert\Regex(
        pattern:"^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$^",
        message: "Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial"
    )]
    #[Assert\length(
        min:8,
        exactMessage: "Le mot de passe doit contenir au moins {{ limit }} caractères"
    )]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: "La longueur maximale est de 8 caractères.")]
    private ?string $cin = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: "La longueur maximale est de 255 caractères.")]
    private ?string $dateNaissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 8, maxMessage: " numéro de téléphone doit contenir 8 chiffres")]

    private ?string $tel = null;

   /* #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "Le champ  est obligatoire.")]
    #[Assert\Length(max: 255, maxMessage: "La longueur maximale est de 255 caractères.")]
    private ?string $photo = null;*/

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: "La longueur maximale est de 255 caractères.")]
    private ?string $adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 2,
        max: 255,
        maxMessage: "La longueur maximale est de 255 caractères."
    )]
    #[Assert\GreaterThan(
        value: 200,
        message: "Le salaire minimum est de 200."
    )]
    private ?string $salaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: "La longueur maximale est de 255 caractères.")]
    private ?string $profession = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: "La longueur maximale est de 255 caractères.")]
    private ?string $poste = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $departement = null;

    #[ORM\Column(length: 255, nullable: true)]

    #[Assert\Length(max: 255, maxMessage: "La longueur maximale est de 255 caractères.")]
    private ?string $dateEambauche = null;
/*
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "Le champ est obligatoire.")]
    #[Assert\Length(max: 255, maxMessage: "La longueur maximale est de 255 caractères.")]
    private ?string $typeStage = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "Le champ est obligatoire.")]
    #[Assert\Length(max: 255, maxMessage: "La longueur maximale est de 255 caractères.")]
    private ?string $dureeStage = null;*/

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: "La longueur maximale est de 255 caractères.")]
    private ?string $name = null;
    
    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;
    #[ORM\Column(type: "boolean")]
    private $isBlocked = false;
    #[ORM\ManyToMany(targetEntity: Stage::class, inversedBy: 'users',orphanRemoval: true)]
    private Collection $stage;
    
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: OffreStage::class)]
    private Collection $offreStages;
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Virement::class)]
    private Collection $virements;

    public function getVirements(): Collection
    {
        return $this->virements;
    }

    public function setVirements(Collection $virements): void
    {
        $this->virements = $virements;
    }

    public function getCheque(): Collection
    {
        return $this->cheque;
    }

    public function setCheque(Collection $cheque): void
    {
        $this->cheque = $cheque;
    }

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Cheque::class)]
    private Collection $cheque;

    #[ORM\ManyToMany(targetEntity: Compte::class, inversedBy: 'users')]
    private Collection $compte;
    
     public function __construct()
     {
         $this->stage = new ArrayCollection();
         $this->offreStages = new ArrayCollection();
         $this->virements = new ArrayCollection();
         $this->cheque = new ArrayCollection();
         $this->compte = new ArrayCollection();
     }
     


    
    
    
    /**
     * @return Collection<int, Stage>
     */
    public function getStage(): Collection
    {
        return $this->stage;
    }
    
    public function addStage(Stage $stage): static
    {
        if (!$this->stage->contains($stage)) {
            $this->stage->add($stage);
        }
        
        return $this;
    }
    
    public function removeStage(Stage $stage): static
    {
        $this->stage->removeElement($stage);
        
        return $this;
    }
    public  function __toString() : String {
        return (String)$this->getId();
    }
    
    /**
     * @return Collection<int, OffreStage>
     */
    public function getOffreStages(): Collection
    {
        return $this->offreStages;
    }
    
    public function addOffreStage(OffreStage $offreStage): static
    {
        if (!$this->offreStages->contains($offreStage)) {
            $this->offreStages->add($offreStage);
            $offreStage->setUser($this);
        }
        
        return $this;
    }
    
    public function removeOffreStage(OffreStage $offreStage): static
    {
        if ($this->offreStages->removeElement($offreStage)) {
            // set the owning side to null (unless already changed)
            if ($offreStage->getUser() === $this) {
                $offreStage->setUser(null);
            }
        }
        
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;

    public function setId(Int $id): static
    {
        $this->id = $id;

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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }
    

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

  

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(?string $cin): static
    {
        $this->cin = $cin;

        return $this;
    }

    public function getDateNaissance(): ?string
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?string $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

   /* public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }*/

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getSalaire(): ?string
    {
        return $this->salaire;
    }

    public function setSalaire(?string $salaire): static
    {
        $this->salaire = $salaire;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(?string $profession): static
    {
        $this->profession = $profession;

        return $this;
    }

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(?string $poste): static
    {
        $this->poste = $poste;

        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(?string $departement): static
    {
        $this->departement = $departement;

        return $this;
    }

    public function getDateEambauche(): ?string
    {
        return $this->dateEambauche;
    }

    public function setDateEambauche(?string $dateEambauche): static
    {
        $this->dateEambauche = $dateEambauche;

        return $this;
    }
/*
    public function getTypeStage(): ?string
    {
        return $this->typeStage;
    }

    public function setTypeStage(?string $typeStage): static
    {
        $this->typeStage = $typeStage;

        return $this;
    }

    public function getDureeStage(): ?string
    {
        return $this->dureeStage;
    }

    public function setDureeStage(?string $dureeStage): static
    {
        $this->dureeStage = $dureeStage;

        return $this;
    }*/

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
    public function isBlocked(): ?bool
{
    return $this->isBlocked;
}

    /**
     * @param bool $isBlocked
     */
    public function setIsBlocked(bool $isBlocked): void
    {
        $this->isBlocked = $isBlocked;
    }

    public function getCompte(): Collection
    {
        return $this->compte;
    }

    public function setCompte(Collection $compte): void
    {
        $this->compte = $compte;

    }
}
