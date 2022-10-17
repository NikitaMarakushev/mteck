<?php

declare(strict_types=1);

namespace App\Product\Application\Command\Product;

use App\Core\Application\Command\CommandInterface;

class DeleteProductCommand implements CommandInterface
{
    public function __construct(
        public readonly int $id
    ) {
    }
}