<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PretsRepository;

#[ORM\Entity(repositoryClass: PretsRepository::class)]
class Prets
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable : true)]
    private ?DateTimeInterface $dateRendu = null;

    #[ORM\Column(type:"boolean", nullable: true)]
    private ?bool $extension = null;

    #[ORM\ManyToOne(inversedBy: 'prets')]
    private ?Livre $livre = null;

    #[ORM\ManyToOne(inversedBy: 'prets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateRendu():?DateTimeInterface
    {
        return $this->dateRendu;
    }

    public function setDateRendu(\DateTimeInterface $dateRendu): static
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
