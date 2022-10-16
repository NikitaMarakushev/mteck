<?php

declare(strict_types=1);

namespace App\Product\Domain\Service;

use App\Product\Domain\Entity\ProductCategory;
use App\Product\Domain\Repository\ProductCategoryRepositoryInterface;

class ProductCategoryChoiceHelper
{
    public function __construct(private readonly ProductCategoryRepositoryInterface $productCategoryRepository)
    {
    }

    public function getChoices(): array
    {
        $categories = $this->productCategoryRepository->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->getQuery()->getResult();

        $categoryChoices = [];
        foreach ($categories as $category) {
            /* @var ProductCategory $category */
            $categoryChoices[$category->getName()] = $category->getId();
        }

        return $categoryChoices;
    }
}