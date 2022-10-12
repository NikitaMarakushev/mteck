<?php

declare(strict_types=1);

namespace App\Product\Application\Command\Customer;

use App\Core\Application\Query\QueryInterface;

class GetCustomerQuery implements QueryInterface
{
    public function __construct(
        public readonly int $id
    )
    {
    }
}
