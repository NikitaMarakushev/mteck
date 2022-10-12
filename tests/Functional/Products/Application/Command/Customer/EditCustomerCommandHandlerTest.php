<?php

declare(strict_types=1);

namespace App\Tests\Functional\Products\Application\Command\Customer;

use App\Product\Application\Command\Customer\EditCustomerCommand;
use App\Product\Domain\Repository\CustomerRepositoryInterface;
use App\Core\Application\Command\CommandBusInterface;
use App\Tests\Resource\Fixture\ProductFixture;
use App\Tests\Tools\FakerTool;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EditCustomerCommandHandlerTest extends WebTestCase
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

    public function testProductEditedSuccessfully(): void
    {
        $executor = $this->databaseTool->loadFixtures([ProductFixture::class]);
        $customer = $executor->getReferenceRepository()->getReference(ProductFixture::getReferenceKey(random_int(1, 3)));

        $name = $this->getFaker()->name();
        $surname = $this->getFaker()->realText();

        $command = new EditCustomerCommand(
            $customer->getId(),
            $name,
            $surname
        );
        $this->commandBus->execute($command);
        $this->entityManager->clear();

        $editedCustomer = $this->customerRepository->find($customer->getId());
        $this->assertEquals($editedCustomer->getName(), $name);
        $this->assertEquals($editedCustomer->getSurname(), $surname);
    }
}
