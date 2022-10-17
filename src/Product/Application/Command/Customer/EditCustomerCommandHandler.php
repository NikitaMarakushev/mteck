<?php

declare(strict_types=1);

namespace App\Product\Application\Command\Customer;

use App\Core\Application\Command\CommandHandlerInterface;
use App\Product\Domain\Repository\CustomerRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class EditCustomerCommandHandler implements CommandHandlerInterface
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