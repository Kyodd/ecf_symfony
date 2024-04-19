<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'Le titre ne peut pas être vide.') ]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $Auteur = null;

    #[ORM\Column(nullable: true)]
    private ?int $anneePublication = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Resume = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column]
    private ?bool $Disponibilite = null;

    #[ORM\Column(nullable: true)]
    private ?float $note = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Etat $etat = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeInterface $dateRendu = null;
    

    /**
     * @var Collection<int, Prets>
     */
    #[ORM\OneToMany(targetEntity: Prets::class, mappedBy: 'livre')]
    private Collection $prets;

   
    public function __construct()
    {
        $this->prets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuteur(): ?string
    {
        return $this->Auteur;
    }

    public function setAuteur(string $Auteur): static
    {
        $this->Auteur = $Auteur;

        return $this;
    }

    public function getAnneePublication(): ?int
    {
        return $this->anneePublication;
    }

    public function setAnneePublication(?int $anneePublication): static
    {
        $this->anneePublication = $anneePublication;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->Resume;
    }

    public function setResume(?string $Resume): static
    {
        $this->Resume = $Resume;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function isDisponibilite(): ?bool
    {
        return $this->Disponibilite;
    }

    public function setDisponibilite(bool $Disponibilite): static
    {
        $this->Disponibilite = $Disponibilite;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(?float $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, Prets>
     */
    public function getPrets(): Collection
    {
        return $this->prets;
    }

    public function addPret(Prets $pret): static
    {
        if (!$this->Pret->contains($pret)) {
            $this->Pret->add($pret);
            $pret->setLivre($this);
        }

        return $this;
    }

    public function removePret(Prets $pret): static
    {
        if ($this->Pret->removeElement($pret)) {
            // set the owning side to null (unless already changed)
            if ($pret->getLivre() === $this) {
                $pret->setLivre(null);
            }
        }

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }
    public function getDateRendu(): ?\DateTimeInterface
    {
        return $this->dateRendu;
    }

    public function setDateRendu(?DateTimeInterface $dateRendu): self
    {
        $this->dateRendu = $dateRendu;

        return $this;
    }
}
