<?php

namespace App\Product\Domain\Repository;

use App\Product\Domain\Entity\Product;
use Doctrine\Persistence\ObjectRepository;

interface ProductRepositoryInterface extends ObjectRepository
{
    public function add(Product $product): void;

    public function update(Product $product): void;

    public function remove(Product $product): void;
}