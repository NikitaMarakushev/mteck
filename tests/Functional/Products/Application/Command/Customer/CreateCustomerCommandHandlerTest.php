<?php

declare(strict_types=1);

namespace App\Tests\Functional\Products\Application\Command\Customer;

use App\Core\Application\Command\CommandBusInterface;
use App\Product\Application\Command\Customer\CreateCustomerCommand;
use App\Product\Domain\Repository\CustomerRepositoryInterface;
use App\Tests\Tools\FakerTool;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateCustomerCommandHandlerTest extends WebTestCase
{
    use FakerTool;

    protected function setUp(): void
    {
        parent::setUp();
        $this->commandBus = static::getContainer()->get(CommandBusInterface::class);
        $this->customerRepository = static::getContainer()->get(CustomerRepositoryInterface::class);
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
    }

    public function testCustomerCreatedSuccessfully(): void
    {
        $command = new CreateCustomerCommand(
            $this->getFaker()->name(),
            $this->getFaker()->realText(),
        );
        $customerId = $this->commandBus->execute($command);
        $this->entityManager->clear();

        $customer = $this->customerRepository->find($customerId);
        $this->assertNotEmpty($customer);
    }
}
