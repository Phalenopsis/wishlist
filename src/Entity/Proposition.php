<?php

namespace App\Entity;

use App\Repository\PropositionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PropositionRepository::class)]
class Proposition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'propositions')]
    private ?User $creator = null;

    #[ORM\ManyToOne(inversedBy: 'propositions')]
    private ?WishList $wish_list = null;

    #[ORM\Column]
    private ?int $difficulty = null;

    #[ORM\ManyToMany(targetEntity: Label::class, mappedBy: 'propositions')]
    private Collection $labels;

    #[ORM\Column]
    private ?bool $done = false;

    public function __construct()
    {
        $this->labels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): static
    {
        $this->creator = $creator;

        return $this;
    }

    public function getWishList(): ?WishList
    {
        return $this->wish_list;
    }

    public function setWishList(?WishList $wish_list): static
    {
        $this->wish_list = $wish_list;

        return $this;
    }

    public function getDifficulty(): ?int
    {
        return $this->difficulty;
    }

    public function setDifficulty(int $difficulty): static
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * @return Collection<int, Label>
     */
    public function getLabels(): Collection
    {
        return $this->labels;
    }

    public function addLabel(Label $label): static
    {
        if (!$this->labels->contains($label)) {
            $this->labels->add($label);
            $label->addProposition($this);
        }

        return $this;
    }

    public function removeLabel(Label $label): static
    {
        if ($this->labels->removeElement($label)) {
            $label->removeProposition($this);
        }

        return $this;
    }

    public function isDone(): ?bool
    {
        return $this->done;
    }

    public function setDone(bool $done): static
    {
        $this->done = $done;

        return $this;
    }
}
