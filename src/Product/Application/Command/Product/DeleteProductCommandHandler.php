<?php

declare(strict_types=1);

namespace App\Product\Application\Command\Product;

use App\Core\Application\Command\CommandHandlerInterface;
use App\Product\Domain\Repository\ProductRepositoryInterface;

class DeleteProductCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly ProductRepositoryInterface $productRepository)
    {
    }

    public function __invoke(DeleteProductCommand $command): void
    {
        $product = $this->productRepository->find($command->id);
        $this->productRepository->remove($product);
    }
}