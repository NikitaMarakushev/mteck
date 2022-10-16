<?php

namespace App\Product\Application\Command\Product;

use App\Core\Application\Query\QueryHandlerInterface;
use App\Product\Application\DTO\ProductDTO;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetProductByCategoryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly ProductRepositoryInterface $productRepository)
    {
    }

    public function __invoke(GetProductByCategory $query): array
    {
        $products = $this->productRepository->findBy(array('category' => $query->categoryId));

        $productDTOs = [];

        foreach ($products as $product) {
            $productDTOs[] = ProductDTO::fromEntity($product);
        }

        return $productDTOs;
    }
}