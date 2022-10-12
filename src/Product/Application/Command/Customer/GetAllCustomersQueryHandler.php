<?php

declare(strict_types=1);

namespace App\Product\Application\Command\Customer;

use App\Core\Application\Query\QueryHandlerInterface;
use App\Product\Application\DTO\CustomerDTO;
use App\Product\Domain\Repository\CustomerRepositoryInterface;

class GetAllCustomersQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly CustomerRepositoryInterface $customerRepository)
    {
    }

    public function __invoke(GetAllCustomersQuery $query): array
    {
        $customers = $this->customerRepository->findBy([], ['name' => 'ASC']);

        $customersDTOs = [];

        foreach ($customers as $customer) {
            $customersDTOs[] = CustomerDTO::fromEntity($customer);
        }

        return $customersDTOs;
    }
}