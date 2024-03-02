<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;
    #[Assert\NotBlank(message:"Veuillez saisir votre commentaire")]
    #[ORM\Column(type: 'text')]
    private ?string $contenu = null;


    #[Assert\NotBlank(message:"Veuillez saisir la date")]
    #[ORM\Column(type: 'datetime')]
   // #[Assert\EqualTo("today", message:"La date de commentaire doit être la date d'aujourd'hui.")]

    private ?\DateTimeInterface $dateCreation = null;

    #[Assert\NotBlank(message: 'Veuillez saisir votre nom ')]
    #[Assert\Length(
        min: 3,
        minMessage: 'Votre nom doit contenir au moins {{ limit }} caractères.'
    )]
    #[Assert\Regex(
        pattern: '/^[A-Z][a-zA-Z]*$/',
        message: "Votre nom doit commencer par une lettre majuscule."
    )]
    #[ORM\Column(length: 255)]
    private ?string $nomAutCom = null;

    #[ORM\ManyToOne(inversedBy: 'commentaire')]
    private ?Article $article = null;

    #[ORM\OneToMany(mappedBy: 'commentaire', targetEntity: ReponseCommentaire::class)]
    private Collection $reponseCommentaires;

    #[ORM\ManyToOne(inversedBy: 'commentaire')]
    private ?User $user = null;

    public function __construct()
    {
        $this->reponseCommentaires = new ArrayCollection();
    }

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

    public function getNomAutCom(): ?string
    {
        return $this->nomAutCom;
    }

    public function setNomAutCom(string $nomAutCom): static
    {
        $this->nomAutCom = $nomAutCom;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        $this->article = $article;

        return $this;
    }

    /**
     * @return Collection<int, ReponseCommentaire>
     */
    public function getReponseCommentaires(): Collection
    {
        return $this->reponseCommentaires;
    }

    public function addReponseCommentaire(ReponseCommentaire $reponseCommentaire): static
    {
        if (!$this->reponseCommentaires->contains($reponseCommentaire)) {
            $this->reponseCommentaires->add($reponseCommentaire);
            $reponseCommentaire->setCommentaire($this);
        }

        return $this;
    }

    public function removeReponseCommentaire(ReponseCommentaire $reponseCommentaire): static
    {
        if ($this->reponseCommentaires->removeElement($reponseCommentaire)) {
            // set the owning side to null (unless already changed)
            if ($reponseCommentaire->getCommentaire() === $this) {
                $reponseCommentaire->setCommentaire(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}