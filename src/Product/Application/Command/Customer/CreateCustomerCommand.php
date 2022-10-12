<?php

declare(strict_types=1);

namespace App\Product\Application\Command\Customer;

use App\Core\Application\Command\CommandInterface;

class CreateCustomerCommand implements CommandInterface
{
    public function __construct(
        public readonly string $name,
        public readonly string $surname,
    ) {
    }
}