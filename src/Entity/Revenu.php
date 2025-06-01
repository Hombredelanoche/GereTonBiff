<?php

namespace App\Entity;

use App\Repository\RevenuRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RevenuRepository::class)]
class Revenu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $salaire = null;

    #[ORM\Column(nullable: true)]
    private ?float $prime = null;

    #[ORM\Column(nullable: true)]
    private ?float $ressourceSup = null;

    #[ORM\Column(length: 255)]
    private ?string $mois = null;

    #[ORM\ManyToOne(inversedBy: 'revenus')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSalaire(): ?float
    {
        return $this->salaire;
    }

    public function setSalaire(float $salaire): static
    {
        $this->salaire = $salaire;

        return $this;
    }

    public function getPrime(): ?float
    {
        return $this->prime;
    }

    public function setPrime(?float $prime): static
    {
        $this->prime = $prime;

        return $this;
    }

    public function getRessourceSup(): ?float
    {
        return $this->ressourceSup;
    }

    public function setRessourceSup(?float $ressourceSup): static
    {
        $this->ressourceSup = $ressourceSup;

        return $this;
    }

    public function getMois(): ?string
    {
        return $this->mois;
    }

    public function setMois(string $mois): static
    {
        $this->mois = $mois;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}
