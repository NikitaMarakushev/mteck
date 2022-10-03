<?php

declare(strict_types=1);

namespace App\Product\Application\DTO;

use App\Product\Domain\Entity\Product;
use App\Product\Infrastructure\Form\ProductType;
use Symfony\Component\Validator\Constraints as Assert;

class ProductFormDTO
{
    private int $id;

    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    #[Assert\Type('string')]
    private string $name;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private string $description;

    #[Assert\NotBlank]
    #[Assert\Type('float')]
    private float $price;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private string $image;

    public static function fromEntity(Product $product): self
    {
        return (new self())
            ->setId($product->getId())
            ->setName($product->getName())
            ->setDescription($product->getDescription())
            ->setPrice($product->getPrice())
            ->setImage($product->getImage());
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}