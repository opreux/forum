<?php

namespace App\Entity;

use App\Repository\AuteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuteurRepository::class)]
class Auteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: Message::class)]
    private Collection $messages;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: FilDiscussion::class)]
    private Collection $filDiscussions;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setAuteur($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getAuteur() === $this) {
                $message->setAuteur(null);
            }
        }

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
            $filDiscussion->setAuteur($this);
        }

        return $this;
    }

    public function removeFilDiscussion(FilDiscussion $filDiscussion): static
    {
        if ($this->filDiscussions->removeElement($filDiscussion)) {
            // set the owning side to null (unless already changed)
            if ($filDiscussion->getAuteur() === $this) {
                $filDiscussion->setAuteur(null);
            }
        }

        return $this;
    }

    public function __toString(): string {
        return $this->getPrenom()." ".$this->getNom();
    }
}
