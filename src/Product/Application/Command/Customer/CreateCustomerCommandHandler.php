<?php

declare(strict_types=1);

namespace App\Product\Application\Command\Customer;

use App\Core\Application\Command\CommandHandlerInterface;
use App\Product\Domain\Entity\Product;
use App\Product\Domain\Repository\ProductRepositoryInterface;

class CreateCustomerCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly ProductRepositoryInterface $productRepository)
    {
    }

    public function __invoke(CreateCustomerCommand $command): int
    {
        $product = new Product(
            $command->name,
            $command->surname
        );

        $this->productRepository->add($product);

        return $product->getId();
    }
}