<?php

declare(strict_types=1);

namespace App\Product\Application\Command\Customer;

use App\Core\Application\Command\CommandInterface;

class EditCustomerCommand implements CommandInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $surname
    ) {
    }
}