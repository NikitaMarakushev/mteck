<?php

declare(strict_types=1);

namespace App\Product\Domain\Entity;

class Customer
{
    public function __construct(
        private string $name,
        private string $surname
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function fillName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function fillSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }
}