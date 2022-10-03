<?php

declare(strict_types=1);

namespace App\Product\Application\Command\Product;

class DeleteProductCommand
{
    public function __construct(
        public readonly int $id
    ) {
    }
}