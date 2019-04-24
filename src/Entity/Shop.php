<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShopRepository")
 * @Serializer\ExclusionPolicy("all")
 */
class Shop
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose()
     * @Serializer\Groups({"api"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=191)
     *
     * @Serializer\Expose()
     * @Serializer\Groups({"api"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=191)
     *
     * @Serializer\Expose()
     * @Serializer\Groups({"api"})
     */
    private $image;

    /**
     * @ORM\Column(type="float")
     *
     * @Serializer\Expose()
     * @Serializer\Groups({"api"})
     */
    private $latitude;

    /**
     * @ORM\Column(type="float")
     *
     * @Serializer\Expose()
     * @Serializer\Groups({"api"})
     */
    private $longitude;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FavoriteShop", mappedBy="shop", orphanRemoval=true)
     */
    private $favoritedBy;

    public function __construct()
    {
        $this->favoritedBy = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return Collection|FavoriteShop[]
     */
    public function getFavoritedBy(): Collection
    {
        return $this->favoritedBy;
    }

    public function addFavoritedBy(FavoriteShop $favoritedBy): self
    {
        if (!$this->favoritedBy->contains($favoritedBy)) {
            $this->favoritedBy[] = $favoritedBy;
            $favoritedBy->setShop($this);
        }

        return $this;
    }

    public function removeFavoritedBy(FavoriteShop $favoritedBy): self
    {
        if ($this->favoritedBy->contains($favoritedBy)) {
            $this->favoritedBy->removeElement($favoritedBy);
            // set the owning side to null (unless already changed)
            if ($favoritedBy->getShop() === $this) {
                $favoritedBy->setShop(null);
            }
        }

        return $this;
    }
}
