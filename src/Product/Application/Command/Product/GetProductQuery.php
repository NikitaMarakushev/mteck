<?php

declare(strict_types=1);

namespace App\Product\Application\Command\Product;

use App\Core\Application\Query\QueryInterface;

class GetProductQuery implements QueryInterface
{
    public function __construct(
        public readonly int $id
    )
    {
    }
}
