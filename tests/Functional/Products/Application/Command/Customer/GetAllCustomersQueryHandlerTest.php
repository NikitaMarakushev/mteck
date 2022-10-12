<?php

declare(strict_types=1);

namespace App\Tests\Functional\Products\Application\Command\Customer;

use App\Core\Application\Query\QueryBusInterface;
use App\Product\Application\Command\Customer\GetAllCustomersQuery;
use App\Tests\Resource\Fixture\CustomerFixture;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetAllCustomersQueryHandlerTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->queryBus = static::getContainer()->get(QueryBusInterface::class);
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
    }

    public function testGetAllCustomerSuccessfully(): void
    {
        $executor = $this->databaseTool->loadFixtures([CustomerFixture::class]);
        $customer = $executor->getReferenceRepository()->getReference(CustomerFixture::getReferenceKey(random_int(1, 3)));
        $name = $customer->getName();
        $this->entityManager->clear();

        $command = new GetAllCustomersQuery();
        $customerDTOs = $this->queryBus->execute($command);
        $names = array_map(static function ($item) {
            return $item->getName();
        }, $customerDTOs);

        self::assertNotEmpty($customerDTOs);
        self::assertContains($name, $names);
    }
}
