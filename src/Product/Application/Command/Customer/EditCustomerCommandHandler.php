<?php

declare(strict_types=1);

namespace App\Product\Application\Command\Customer;

use App\Product\Domain\Repository\CustomerRepositoryInterface;

class EditCustomerCommandHandler
{
    public function __construct(private readonly CustomerRepositoryInterface $customerRepository)
    {
    }

    public function __invoke(EditCustomerCommand $command): void
    {
        $customer = $this->customerRepository->find($command->id);

        $customer
            ->fillName($command->name)
            ->fillSurname($command->surname);

        $this->customerRepository->update($customer);
    }
}