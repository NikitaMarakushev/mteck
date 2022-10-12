<?php

declare(strict_types=1);

namespace App\Product\Domain\Repository;

use App\Product\Domain\Entity\Customer;

interface CustomerRepositoryInterface
{
    public function add(Customer $customer): void;

    public function update(Customer $customer): void;

    public function remove(Customer $customer): void;
}