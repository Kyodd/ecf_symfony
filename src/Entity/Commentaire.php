<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $commentAdmin = null;

    #[ORM\ManyToOne(inversedBy: 'commentaires')]
    private ?Prets $pret = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentAdmin(): ?string
    {
        return $this->commentAdmin;
    }

    public function setCommentAdmin(string $commentAdmin): static
    {
        $this->commentAdmin = $commentAdmin;

        return $this;
    }

    public function getPret(): ?Prets
    {
        return $this->pret;
    }

    public function setPret(?Prets $pret): static
    {
        $this->pret = $pret;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }
}
