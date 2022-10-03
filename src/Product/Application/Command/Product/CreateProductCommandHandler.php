<?php

declare(strict_types=1);

namespace App\Product\Application\Command\Product;

use App\Core\Application\Command\CommandHandlerInterface;
use App\Product\Domain\Entity\Product;
use App\Product\Domain\Repository\ProductRepositoryInterface;

class CreateProductCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly ProductRepositoryInterface $productRepository)
    {
    }

    public function __invoke(CreateProductCommand $command): int
    {
        $product = new Product(
            $command->name,
            $command->description,
            $command->price,
            $command->image
        );

        $this->productRepository->add($product);

        return $product->getId();
    }
}