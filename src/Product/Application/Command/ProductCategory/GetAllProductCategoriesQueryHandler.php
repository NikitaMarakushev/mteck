<?php

declare(strict_types=1);

namespace App\Product\Application\Command\ProductCategory;

use App\Core\Application\Command\CommandHandlerInterface;
use App\Product\Application\DTO\ProductCategoryDTO;
use App\Product\Domain\Repository\ProductCategoryRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetAllProductCategoriesQueryHandler  implements CommandHandlerInterface
{
    public function __construct(private readonly ProductCategoryRepositoryInterface $productCategoryRepository)
    {
    }

    public function __invoke(GetAllProductCategoriesQuery $query): array
    {
        $productCategories = $this->productCategoryRepository->findBy([], ['name' => 'ASC']);

        $productCategoriesDTOs = [];

        foreach ($productCategories as $productCategory) {
            $productCategoriesDTOs[] = ProductCategoryDTO::fromEntity($productCategory);
        }

        return $productCategoriesDTOs;
    }
}