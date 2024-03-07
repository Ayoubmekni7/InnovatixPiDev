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

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: CommentaireHadhemi::class)]
    private Collection $commentaire;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Article::class)]
    private Collection $article;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Reclamation::class)]
    private Collection $reclamation;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Reponse::class)]
    private Collection $reponse;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ReponseCommentaire::class)]
    private Collection $reponseCommentaire;

    public function __construct()
    {
        $this->commentaire = new ArrayCollection();
        $this->article = new ArrayCollection();
        $this->reclamation = new ArrayCollection();
        $this->reponse = new ArrayCollection();
        $this->reponseCommentaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, CommentaireHadhemi>
     */
    public function getCommentaire(): Collection
    {
        return $this->commentaire;
    }

    public function addCommentaire(CommentaireHadhemi $commentaire): static
    {
        if (!$this->commentaire->contains($commentaire)) {
            $this->commentaire->add($commentaire);
            $commentaire->setUser($this);
        }

        return $this;
    }

    public function removeCommentaire(CommentaireHadhemi $commentaire): static
    {
        if ($this->commentaire->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getUser() === $this) {
                $commentaire->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Article $article): static
    {
        if (!$this->article->contains($article)) {
            $this->article->add($article);
            $article->setUser($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): static
    {
        if ($this->article->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getUser() === $this) {
                $article->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reclamation>
     */
    public function getReclamation(): Collection
    {
        return $this->reclamation;
    }

    public function addReclamation(Reclamation $reclamation): static
    {
        if (!$this->reclamation->contains($reclamation)) {
            $this->reclamation->add($reclamation);
            $reclamation->setUser($this);
        }

        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): static
    {
        if ($this->reclamation->removeElement($reclamation)) {
            // set the owning side to null (unless already changed)
            if ($reclamation->getUser() === $this) {
                $reclamation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reponse>
     */
    public function getReponse(): Collection
    {
        return $this->reponse;
    }

    public function addReponse(Reponse $reponse): static
    {
        if (!$this->reponse->contains($reponse)) {
            $this->reponse->add($reponse);
            $reponse->setUser($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): static
    {
        if ($this->reponse->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getUser() === $this) {
                $reponse->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ReponseCommentaire>
     */
    public function getReponseCommentaire(): Collection
    {
        return $this->reponseCommentaire;
    }

    public function addReponseCommentaire(ReponseCommentaire $reponseCommentaire): static
    {
        if (!$this->reponseCommentaire->contains($reponseCommentaire)) {
            $this->reponseCommentaire->add($reponseCommentaire);
            $reponseCommentaire->setUser($this);
        }

        return $this;
    }

    public function removeReponseCommentaire(ReponseCommentaire $reponseCommentaire): static
    {
        if ($this->reponseCommentaire->removeElement($reponseCommentaire)) {
            // set the owning side to null (unless already changed)
            if ($reponseCommentaire->getUser() === $this) {
                $reponseCommentaire->setUser(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return (String)$this->getId();
    }
}
