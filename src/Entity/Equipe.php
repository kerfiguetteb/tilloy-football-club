<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipeRepository::class)]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $categorie = null;

    #[ORM\Column(length: 255)]
    private ?string $groupe = null;

    #[ORM\OneToMany(mappedBy: 'equipe', targetEntity: Entraineur::class)]
    private Collection $entraineur;

    #[ORM\OneToMany(mappedBy: 'equipe', targetEntity: Joueur::class)]
    private Collection $joueur;

    #[ORM\OneToMany(mappedBy: 'equipe', targetEntity: Domicile::class)]
    private Collection $domiciles;

    #[ORM\OneToMany(mappedBy: 'equipe', targetEntity: Visiteur::class)]
    private Collection $visiteurs;

    public function __construct()
    {
        $this->entraineur = new ArrayCollection();
        $this->joueur = new ArrayCollection();
        $this->domiciles = new ArrayCollection();
        $this->visiteurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getGroupe(): ?string
    {
        return $this->groupe;
    }

    public function setGroupe(string $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * @return Collection<int, Entraineur>
     */
    public function getEntraineur(): Collection
    {
        return $this->entraineur;
    }

    public function addEntraineur(Entraineur $entraineur): self
    {
        if (!$this->entraineur->contains($entraineur)) {
            $this->entraineur->add($entraineur);
            $entraineur->setEquipe($this);
        }

        return $this;
    }

    public function removeEntraineur(Entraineur $entraineur): self
    {
        if ($this->entraineur->removeElement($entraineur)) {
            // set the owning side to null (unless already changed)
            if ($entraineur->getEquipe() === $this) {
                $entraineur->setEquipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Joueur>
     */
    public function getJoueur(): Collection
    {
        return $this->joueur;
    }

    public function addJoueur(Joueur $joueur): self
    {
        if (!$this->joueur->contains($joueur)) {
            $this->joueur->add($joueur);
            $joueur->setEquipe($this);
        }

        return $this;
    }

    public function removeJoueur(Joueur $joueur): self
    {
        if ($this->joueur->removeElement($joueur)) {
            // set the owning side to null (unless already changed)
            if ($joueur->getEquipe() === $this) {
                $joueur->setEquipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Domicile>
     */
    public function getDomiciles(): Collection
    {
        return $this->domiciles;
    }

    public function addDomicile(Domicile $domicile): self
    {
        if (!$this->domiciles->contains($domicile)) {
            $this->domiciles->add($domicile);
            $domicile->setEquipe($this);
        }

        return $this;
    }

    public function removeDomicile(Domicile $domicile): self
    {
        if ($this->domiciles->removeElement($domicile)) {
            // set the owning side to null (unless already changed)
            if ($domicile->getEquipe() === $this) {
                $domicile->setEquipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Visiteur>
     */
    public function getVisiteurs(): Collection
    {
        return $this->visiteurs;
    }

    public function addVisiteur(Visiteur $visiteur): self
    {
        if (!$this->visiteurs->contains($visiteur)) {
            $this->visiteurs->add($visiteur);
            $visiteur->setEquipe($this);
        }

        return $this;
    }

    public function removeVisiteur(Visiteur $visiteur): self
    {
        if ($this->visiteurs->removeElement($visiteur)) {
            // set the owning side to null (unless already changed)
            if ($visiteur->getEquipe() === $this) {
                $visiteur->setEquipe(null);
            }
        }

        return $this;
    }
}
