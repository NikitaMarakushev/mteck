<?php

declare(strict_types=1);

namespace App\Product\Application\Command\Customer;

use App\Core\Application\Command\CommandHandlerInterface;
use App\Product\Domain\Repository\CustomerRepositoryInterface;

class DeleteCustomerCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly CustomerRepositoryInterface $customerRepository)
    {
    }

    public function __invoke(DeleteCustomerCommand $command): void
    {
        $customer = $this->customerRepository->find($command->id);
        $this->customerRepository->remove($customer);
    }
}