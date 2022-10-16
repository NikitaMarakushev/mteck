<?php

declare(strict_types=1);

namespace App\Product\Domain\Repository;

use App\Product\Domain\Entity\ProductCategory;
use Doctrine\Persistence\ObjectRepository;

interface ProductCategoryRepositoryInterface  extends ObjectRepository
{
    public function add(ProductCategory $product): void;

    public function update(ProductCategory $product): void;

    public function remove(ProductCategory $product): void;
}