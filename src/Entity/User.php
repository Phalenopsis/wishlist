<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'creator', targetEntity: WishList::class)]
    private Collection $wishLists;

    #[ORM\ManyToMany(targetEntity: WishList::class, mappedBy: 'contributors')]
    private Collection $wishListsContribute;

    #[ORM\OneToMany(mappedBy: 'creator', targetEntity: Proposition::class)]
    private Collection $propositions;

    public function __construct()
    {
        $this->wishLists = new ArrayCollection();
        $this->wishListsContribute = new ArrayCollection();
        $this->propositions = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection<int, WishList>
     */
    public function getWishLists(): Collection
    {
        return $this->wishLists;
    }

    public function addWishList(WishList $wishList): static
    {
        if (!$this->wishLists->contains($wishList)) {
            $this->wishLists->add($wishList);
            $wishList->setCreator($this);
        }

        return $this;
    }

    public function removeWishList(WishList $wishList): static
    {
        if ($this->wishLists->removeElement($wishList)) {
            // set the owning side to null (unless already changed)
            if ($wishList->getCreator() === $this) {
                $wishList->setCreator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, WishList>
     */
    public function getWishListsContribute(): Collection
    {
        return $this->wishListsContribute;
    }

    public function addWishListsContribute(WishList $wishListsContribute): static
    {
        if (!$this->wishListsContribute->contains($wishListsContribute)) {
            $this->wishListsContribute->add($wishListsContribute);
            $wishListsContribute->addContributor($this);
        }

        return $this;
    }

    public function removeWishListsContribute(WishList $wishListsContribute): static
    {
        if ($this->wishListsContribute->removeElement($wishListsContribute)) {
            $wishListsContribute->removeContributor($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Proposition>
     */
    public function getPropositions(): Collection
    {
        return $this->propositions;
    }

    public function addProposition(Proposition $proposition): static
    {
        if (!$this->propositions->contains($proposition)) {
            $this->propositions->add($proposition);
            $proposition->setCreator($this);
        }

        return $this;
    }

    public function removeProposition(Proposition $proposition): static
    {
        if ($this->propositions->removeElement($proposition)) {
            // set the owning side to null (unless already changed)
            if ($proposition->getCreator() === $this) {
                $proposition->setCreator(null);
            }
        }

        return $this;
    }
}
