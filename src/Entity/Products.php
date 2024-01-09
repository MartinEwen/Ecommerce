<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductsRepository::class)]
class Products
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nameProducts = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\OneToMany(mappedBy: 'products', targetEntity: Cart::class)]
    private Collection $carts;

    #[ORM\ManyToMany(targetEntity: Favoris::class, mappedBy: 'products')]
    private Collection $favoris;

    #[ORM\ManyToMany(targetEntity: Pictures::class, mappedBy: 'products')]
    private Collection $pictures;

    public function __construct()
    {
        $this->carts = new ArrayCollection();
        $this->favoris = new ArrayCollection();
        $this->pictures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameProducts(): ?string
    {
        return $this->nameProducts;
    }

    public function setNameProducts(string $nameProducts): static
    {
        $this->nameProducts = $nameProducts;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, Cart>
     */
    public function getCarts(): Collection
    {
        return $this->carts;
    }

    public function addCart(Cart $cart): static
    {
        if (!$this->carts->contains($cart)) {
            $this->carts->add($cart);
            $cart->setProducts($this);
        }

        return $this;
    }

    public function removeCart(Cart $cart): static
    {
        if ($this->carts->removeElement($cart)) {
            // set the owning side to null (unless already changed)
            if ($cart->getProducts() === $this) {
                $cart->setProducts(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Favoris>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(Favoris $favori): static
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris->add($favori);
            $favori->addProduct($this);
        }

        return $this;
    }

    public function removeFavori(Favoris $favori): static
    {
        if ($this->favoris->removeElement($favori)) {
            $favori->removeProduct($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Pictures>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Pictures $picture): static
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures->add($picture);
            $picture->addProduct($this);
        }

        return $this;
    }

    public function removePicture(Pictures $picture): static
    {
        if ($this->pictures->removeElement($picture)) {
            $picture->removeProduct($this);
        }

        return $this;
    }
}
