<?php

declare(strict_types=1);

namespace App\Product\Application\Command\Product;

use App\Core\Application\Query\QueryHandlerInterface;
use App\Product\Application\DTO\ProductDTO;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetProductQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly ProductRepositoryInterface $productRepository)
    {
    }

    public function __invoke(GetProductQuery $query): ProductDTO
    {
        $product = $this->productRepository->find($query->id);

        return ProductDTO::fromEntity($product);
    }
}