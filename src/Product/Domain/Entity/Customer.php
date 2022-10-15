<?php

declare(strict_types=1);

namespace App\Product\Domain\Entity;

class Customer
{
    private int $id;

    private string $name;

    private string $surname;

    public function __construct(
         string $name,
         string $surname
    ) {
        $this->name = $name;
        $this->surname = $surname;
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