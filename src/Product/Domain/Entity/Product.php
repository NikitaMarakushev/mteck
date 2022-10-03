<?php

declare(strict_types=1);

namespace App\Product\Domain\Entity;

class Product
{
    private int $id;

    private string $name;

    private string $description;

    private float $price;

    private string $image;

    public function __construct(
        string $name,
        string $description,
        float $price,
        string $image
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->image = $image;
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function fillDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function fillPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function fillImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}