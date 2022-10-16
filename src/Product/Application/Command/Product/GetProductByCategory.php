<?php

declare(strict_types=1);

namespace App\Product\Application\Command\Product;

use App\Core\Application\Query\QueryInterface;

class GetProductByCategory  implements QueryInterface
{
    public function __construct(
        public readonly int $categoryId
    )
    {
    }
}