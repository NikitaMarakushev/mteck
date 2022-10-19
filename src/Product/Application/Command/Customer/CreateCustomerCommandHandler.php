<?php

declare(strict_types=1);

namespace App\Product\Application\Command\Customer;

use App\Core\Application\Command\CommandHandlerInterface;
use App\Product\Domain\Entity\Customer;
use App\Product\Domain\Repository\CustomerRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateCustomerCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly CustomerRepositoryInterface $customerRepository)
    {
    }

    public function __invoke(CreateCustomerCommand $command): int
    {
        $customer = new Customer(
            $command->name,
            $command->surname
        );

        $this->customerRepository->add($customer);

        return $customer->getId();
    }
}