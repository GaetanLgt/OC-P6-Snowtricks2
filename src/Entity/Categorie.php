<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Trick::class, inversedBy: 'categories')]
    private Collection $Trick;

    public function __construct()
    {
        $this->Trick = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Trick>
     */
    public function getTrick(): Collection
    {
        return $this->Trick;
    }

    public function addTrick(Trick $trick): static
    {
        if (!$this->Trick->contains($trick)) {
            $this->Trick->add($trick);
        }

        return $this;
    }

    public function removeTrick(Trick $trick): static
    {
        $this->Trick->removeElement($trick);

        return $this;
    }
}
