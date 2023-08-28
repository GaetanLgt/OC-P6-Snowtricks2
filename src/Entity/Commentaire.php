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

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $publishedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $pseudoAuteur = null;

    #[ORM\Column(length: 255)]
    private ?string $imageProfilAuteur = null;

    #[ORM\ManyToOne(inversedBy: 'commentaires')]
    private ?Trick $Trick = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeImmutable $publishedAt): static
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getPseudoAuteur(): ?string
    {
        return $this->pseudoAuteur;
    }

    public function setPseudoAuteur(string $pseudoAuteur): static
    {
        $this->pseudoAuteur = $pseudoAuteur;

        return $this;
    }

    public function getImageProfilAuteur(): ?string
    {
        return $this->imageProfilAuteur;
    }

    public function setImageProfilAuteur(string $imageProfilAuteur): static
    {
        $this->imageProfilAuteur = $imageProfilAuteur;

        return $this;
    }

    public function getTrick(): ?Trick
    {
        return $this->Trick;
    }

    public function setTrick(?Trick $Trick): static
    {
        $this->Trick = $Trick;

        return $this;
    }
}
