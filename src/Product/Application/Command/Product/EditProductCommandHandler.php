<?php

declare(strict_types=1);

namespace App\Product\Application\Command\Product;

use App\Product\Domain\Repository\ProductRepositoryInterface;

class EditProductCommandHandler
{
    public function __construct(private readonly ProductRepositoryInterface $productRepository)
    {
    }

    public function __invoke(EditProductCommand $command): void
    {
        $product = $this->productRepository->find($command->id);

        $product
            ->fillName($command->name)
            ->fillDescription($command->description)
            ->fillPrice($command->price)
            ->fillImage($command->image);

        $this->productRepository->update($product);
    }
}