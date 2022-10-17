<?php

namespace App\Entity;

use App\Repository\ConvocationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConvocationRepository::class)]
class Convocation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $disponibiliter = null;

    #[ORM\ManyToOne(inversedBy: 'convocations')]
    private ?Game $game = null;

    #[ORM\ManyToOne(inversedBy: 'convocations')]
    private ?Joueur $joueur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isDisponibiliter(): ?bool
    {
        return $this->disponibiliter;
    }

    public function setDisponibiliter(?bool $disponibiliter): self
    {
        $this->disponibiliter = $disponibiliter;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getJoueur(): ?Joueur
    {
        return $this->joueur;
    }

    public function setJoueur(?Joueur $joueur): self
    {
        $this->joueur = $joueur;

        return $this;
    }

 
}
