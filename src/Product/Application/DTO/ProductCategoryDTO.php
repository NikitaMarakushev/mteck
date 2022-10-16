<?php

declare(strict_types=1);

namespace App\Product\Application\DTO;

use App\Product\Domain\Entity\ProductCategory;

class ProductCategoryDTO
{
    private ?int $id;

    private string $name;

    public static function fromEntity(ProductCategory $productCategory): self
    {
        return (new self())
            ->setId($productCategory->getId())
            ->setName($productCategory->getName());
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
}