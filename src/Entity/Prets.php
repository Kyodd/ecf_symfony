<?php

namespace App\Entity;

use App\Repository\PretsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PretsRepository::class)]
class Prets
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $dateDebut = null;

    #[ORM\Column]
    private ?int $dateFin = null;

    #[ORM\Column]
    private ?int $dateRendu = null;

    #[ORM\Column(nullable: true)]
    private ?int $extension = null;

    #[ORM\ManyToOne(inversedBy: 'Pret')]
    private ?Livre $livre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?int
    {
        return $this->dateDebut;
    }

    public function setDateDebut(int $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?int
    {
        return $this->dateFin;
    }

    public function setDateFin(int $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getDateRendu(): ?int
    {
        return $this->dateRendu;
    }

    public function setDateRendu(int $dateRendu): static
    {
        $this->dateRendu = $dateRendu;

        return $this;
    }

    public function getExtension(): ?int
    {
        return $this->extension;
    }

    public function setExtension(?int $extension): static
    {
        $this->extension = $extension;

        return $this;
    }

    public function getLivre(): ?Livre
    {
        return $this->livre;
    }

    public function setLivre(?Livre $livre): static
    {
        $this->livre = $livre;

        return $this;
    }
}
