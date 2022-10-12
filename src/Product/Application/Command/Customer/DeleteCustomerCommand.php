<?php

declare(strict_types=1);

namespace App\Product\Application\Command\Customer;

class DeleteCustomerCommand
{
    public function __construct(
        public readonly int $id
    ) {
    }
}