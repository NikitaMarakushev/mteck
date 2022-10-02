<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    private $email;

    private $roles = [];

    private $password;

    private $firstname;

    private $pseudoname;

    private $wishList;

    private $reviews;

    private $cartItems;

    private $addresses;

    private $orders;

    private $contacts;

    private $confirmation;

    private $modifPasswords;

    private $promoCodes;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->cartItems = new ArrayCollection();
        $this->addresses = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->contacts = new ArrayCollection();
        $this->modifPasswords = new ArrayCollection();
        $this->promoCodes = new ArrayCollection();
    }

    public function getPassword(): ?string
    {
        // TODO: Implement getPassword() method.
    }

    public function getRoles(): array
    {
        // TODO: Implement getRoles() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        // TODO: Implement getUserIdentifier() method.
    }
}