<?php

namespace App\Entity;

use App\Repository\ThemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThemeRepository::class)]
class Theme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'theme', targetEntity: FilDiscussion::class)]
    private Collection $filDiscussions;

    public function __construct()
    {
        $this->filDiscussions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, FilDiscussion>
     */
    public function getFilDiscussions(): Collection
    {
        return $this->filDiscussions;
    }

    public function addFilDiscussion(FilDiscussion $filDiscussion): static
    {
        if (!$this->filDiscussions->contains($filDiscussion)) {
            $this->filDiscussions->add($filDiscussion);
            $filDiscussion->setTheme($this);
        }

        return $this;
    }

    public function removeFilDiscussion(FilDiscussion $filDiscussion): static
    {
        if ($this->filDiscussions->removeElement($filDiscussion)) {
            // set the owning side to null (unless already changed)
            if ($filDiscussion->getTheme() === $this) {
                $filDiscussion->setTheme(null);
            }
        }

        return $this;
    }
}
