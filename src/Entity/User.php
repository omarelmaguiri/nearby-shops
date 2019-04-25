<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @Serializer\ExclusionPolicy("all")
 */
class User implements UserInterface, EquatableInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=191, unique=true)
     *
     * @Serializer\Expose()
     * @Serializer\Groups({"login", "signup", "signup_doc"})
     *
     * @Assert\Email(groups={"signup"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * Plain password. Used for model validation. Must not be persisted.
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Expose()
     * @Serializer\Groups({"signup_doc"})
     *
     * @Assert\NotBlank(groups={"signup"})
     */
    private $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FavoriteShop", mappedBy="user", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $favoriteShops;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DislikedShop", mappedBy="user", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $dislikedShops;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->favoriteShops = new ArrayCollection();
        $this->dislikedShops = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Gets the plain password.
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Sets the plain password.
     *
     * @param string $password
     *
     * @return static
     */
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
        return $this;
    }

    /**
     * @return Collection|FavoriteShop[]
     */
    public function getFavoriteShops(): Collection
    {
        return $this->favoriteShops;
    }

    public function addFavoriteShop(FavoriteShop $favoriteShop): self
    {
        if (!$this->favoriteShops->contains($favoriteShop)) {
            $this->favoriteShops[] = $favoriteShop;
            $favoriteShop->setUser($this);
        }

        return $this;
    }

    public function removeFavoriteShop(FavoriteShop $favoriteShop): self
    {
        if ($this->favoriteShops->contains($favoriteShop)) {
            $this->favoriteShops->removeElement($favoriteShop);
            // set the owning side to null (unless already changed)
            if ($favoriteShop->getUser() === $this) {
                $favoriteShop->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DislikedShop[]
     */
    public function getDislikedShops(): Collection
    {
        return $this->dislikedShops;
    }

    /**
     * @return Collection|DislikedShop[]
     */
    public function getLastDislikedShops(): Collection
    {
        return $this->dislikedShops->filter(function ($dislikedShop) {
            $createdAt = clone $dislikedShop->getCreatedAt();
            return new \DateTime() > $createdAt->add(new \DateInterval(DislikedShop::DISLIKE_TIME_INTERVAL));
        });
    }

    public function addDislikedShop(DislikedShop $dislikedShop): self
    {
        if (!$this->dislikedShops->contains($dislikedShop)) {
            $this->dislikedShops[] = $dislikedShop;
            $dislikedShop->setUser($this);
        }

        return $this;
    }

    public function removeDislikedShop(DislikedShop $dislikedShop): self
    {
        if ($this->dislikedShops->contains($dislikedShop)) {
            $this->dislikedShops->removeElement($dislikedShop);
            // set the owning side to null (unless already changed)
            if ($dislikedShop->getUser() === $this) {
                $dislikedShop->setUser(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->getEmail();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->email,
            $this->password,
        ]);
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
          ) = unserialize($serialized);
    }

    /**
     * The equality comparison should neither be done by referential equality
     * nor by comparing identities (i.e. getId() === getId()).
     *
     * However, you do not need to compare every attribute, but only those that
     * are relevant for assessing whether re-authentication is required.
     *
     * @return bool
     */
    public function isEqualTo(UserInterface $user)
    {
        return $this->email === $user->getUsername() && $this->password === $user->getPassword();
    }
}
