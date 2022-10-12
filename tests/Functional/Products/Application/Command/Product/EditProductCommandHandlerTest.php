<?php

declare(strict_types=1);

namespace App\Tests\Functional\Products\Application\Command\Product;

use App\Product\Application\Command\Product\EditProductCommand;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Core\Application\Command\CommandBusInterface;
use App\Tests\Resource\Fixture\ProductFixture;
use App\Tests\Tools\FakerTool;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EditProductCommandHandlerTest extends WebTestCase
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

    public function testProductEditedSuccessfully(): void
    {
        $executor = $this->databaseTool->loadFixtures([ProductFixture::class]);
        $product = $executor->getReferenceRepository()->getReference(ProductFixture::getReferenceKey(random_int(1, 3)));

        $name = $this->getFaker()->name();
        $description = $this->getFaker()->realText();
        $price = $this->getFaker()->numberBetween(1, 9);
        $image = $this->getFaker()->realText();

        $command = new EditProductCommand(
            $product->getId(),
            $name,
            $description,
            $price,
            $image,
        );
        $this->commandBus->execute($command);
        $this->entityManager->clear();

        $editedProduct = $this->productRepository->find($product->getId());
        $this->assertEquals($editedProduct->getName(), $name);
        $this->assertEquals($editedProduct->getDescription(), $description);
        $this->assertEquals($editedProduct->getPrice(), $price);
        $this->assertEquals($editedProduct->getImage(), $image);
    }
}
