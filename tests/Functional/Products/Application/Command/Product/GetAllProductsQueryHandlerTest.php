<?php

declare(strict_types=1);

namespace App\Tests\Functional\Products\Application\Command\Product;

use App\Core\Application\Query\QueryBusInterface;
use App\Product\Application\Command\Product\GetAllProductsQuery;
use App\Tests\Resource\Fixture\ProductFixture;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetAllProductsQueryHandlerTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->queryBus = static::getContainer()->get(QueryBusInterface::class);
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
    }

    public function testGetAllProductSuccessfully(): void
    {
        $executor = $this->databaseTool->loadFixtures([ProductFixture::class]);
        $product = $executor->getReferenceRepository()->getReference(ProductFixture::getReferenceKey(random_int(1, 3)));
        $name = $product->getName();
        $this->entityManager->clear();

        $command = new GetAllProductsQuery();
        $productDTOs = $this->queryBus->execute($command);
        $names = array_map(static function ($item) {
            return $item->getName();
        }, $productDTOs);

        self::assertNotEmpty($productDTOs);
        self::assertContains($name, $names);
    }
}
