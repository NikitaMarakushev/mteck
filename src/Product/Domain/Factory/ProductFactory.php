<?php

namespace App\Product\Domain\Factory;

use App\Product\Domain\Entity\Product;

class ProductFactory
{
    public function create(string $name, string $description, float $price, string $image): Product
    {
        return new Product($name, $description, $price, $image);
    }
}