<?php

declare(strict_types=1);

namespace App\Product\Application\Command\Product;

use App\Core\Application\Command\CommandInterface;

class EditProductCommand implements CommandInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $description,
        public readonly float $price,
        public readonly string $image,
    ) {
    }
}