<?php

declare(strict_types=1);

namespace App\Product\Domain\Entity;

class ProductCategory
{
    private int $id;

    private string $name;

    public function __construct(
        string $name,
    ) {
        $this->name = $name;
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
}