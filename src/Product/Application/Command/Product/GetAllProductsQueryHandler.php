<?php

declare(strict_types=1);

namespace App\Product\Application\Command\Product;

use App\Core\Application\Query\QueryHandlerInterface;
use App\Product\Application\DTO\ProductDTO;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetAllProductsQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly ProductRepositoryInterface $productRepository)
    {
    }

    public function __invoke(GetAllProductsQuery $query): array
    {
        $products = $this->productRepository->findBy([], ['name' => 'ASC']);

        $productDTOs = [];

        foreach ($products as $product) {
            $productDTOs[] = ProductDTO::fromEntity($product);
        }

        return $productDTOs;
    }
}