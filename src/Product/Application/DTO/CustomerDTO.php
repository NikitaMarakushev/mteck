<?php

declare(strict_types=1);

namespace App\Product\Application\DTO;

use App\Product\Domain\Entity\Customer;

class CustomerDTO
{
    private ?int $id;

    private string $name;

    private string $surname;

    public static function fromEntity(Customer $customer): self
    {
        return (new self())
            ->setId($customer->getId())
            ->setName($customer->getName())
            ->setSurname($customer->getSurname());
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }
}