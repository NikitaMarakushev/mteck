<?php

declare(strict_types=1);

namespace App\Tests\Functional\Product\Application\Command\Customer;

use App\Core\Application\Command\CommandBusInterface;
use App\Product\Application\Command\Customer\DeleteCustomerCommand;
use App\Product\Domain\Repository\CustomerRepositoryInterface;
use App\Tests\Resource\Fixture\CustomerFixture;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DeleteCustomerCommandHandlerTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->commandBus = static::getContainer()->get(CommandBusInterface::class);
        $this->customerRepository = static::getContainer()->get(CustomerRepositoryInterface::class);
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
    }

    public function testCustomerDeletedSuccessfully(): void
    {
        $executor = $this->databaseTool->loadFixtures([CustomerFixture::class]);
        $customer = $executor->getReferenceRepository()->getReference(CustomerFixture::getReferenceKey(random_int(1, 3)));
        $id = $customer->getId();
        $this->entityManager->clear();

        $command = new DeleteCustomerCommand($id);
        $this->commandBus->execute($command);

        $deletedCustomer = $this->customerRepository->find($id);
        $this->assertEmpty($deletedCustomer);
    }
}
