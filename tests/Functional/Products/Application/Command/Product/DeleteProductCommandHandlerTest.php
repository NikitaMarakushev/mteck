<?php

declare(strict_types=1);

namespace App\Tests\Functional\Products\Application\Command\Product;

use App\Product\Application\Command\Product\DeleteCustomerCommand;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Core\Application\Command\CommandBusInterface;
use App\Tests\Resource\Fixture\ProductFixture;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DeleteProductCommandHandlerTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->commandBus = static::getContainer()->get(CommandBusInterface::class);
        $this->productRepository = static::getContainer()->get(ProductRepositoryInterface::class);
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
    }

    public function testProductDeletedSuccessfully(): void
    {
        $executor = $this->databaseTool->loadFixtures([ProductFixture::class]);
        $product = $executor->getReferenceRepository()->getReference(ProductFixture::getReferenceKey(random_int(1, 3)));
        $id = $product->getId();
        $this->entityManager->clear();

        $command = new DeleteCustomerCommand($id);
        $this->commandBus->execute($command);

        $deletedProduct = $this->productRepository->find($id);
        $this->assertEmpty($deletedProduct);
    }
}
