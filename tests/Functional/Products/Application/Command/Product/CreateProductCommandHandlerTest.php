<?php

declare(strict_types=1);

namespace App\Tests\Functional\Products\Application\Command\Product;

use App\Product\Application\Command\Product\CreateProductCommand;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Core\Application\Command\CommandBusInterface;
use App\Tests\Tools\FakerTool;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateProductCommandHandlerTest extends WebTestCase
{
    use FakerTool;

    protected function setUp(): void
    {
        parent::setUp();
        $this->commandBus = static::getContainer()->get(CommandBusInterface::class);
        $this->productRepository = static::getContainer()->get(ProductRepositoryInterface::class);
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
    }

    public function testProductCreatedSuccessfully(): void
    {
        $command = new CreateProductCommand(
            $this->getFaker()->name(),
            $this->getFaker()->realText(),
            $this->getFaker()->numberBetween(1, 9),
            'image/'.$this->getFaker()->buildingNumber().'.jpg',
        );
        $productId = $this->commandBus->execute($command);
        $this->entityManager->clear();

        $product = $this->productRepository->find($productId);
        $this->assertNotEmpty($product);
    }
}
