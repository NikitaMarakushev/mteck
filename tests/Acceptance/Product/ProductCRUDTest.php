<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\Product;

use App\Product\Domain\Entity\Product;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Tests\Resource\Fixture\ProductFixture;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductCRUDTest extends WebTestCase
{
    private const PRODUCT_NAME = 'Название';

    private const PRODUCT_DESCRIPTION = 'Описание';

    private const PRODUCT_PRICE = '100.00';

    private const PRODUCT_IMAGE = 'Изображение';

    private const PRODUCT_NAME_EDITED = 'Новое название';

    private const PRODUCT_DESCRIPTION_EDITED = 'Новое описание';

    private const PRODUCT_PRICE_EDITED = '101.00';

    private const PRODUCT_IMAGE_EDITED = 'Новое изображение';

    protected function setUp(): void
    {
        $this->productRepository = static::getContainer()->get(ProductRepositoryInterface::class);
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        self::ensureKernelShutdown();
    }

    public function testProductListDisplayed(): void
    {
        $client = static::createClient();
        $client->request('GET', '/product');
        $content = $client->getResponse()->getContent();

        self::assertResponseIsSuccessful();
        self::assertStringContainsString('Все продукты', $content);
        self::assertStringContainsString(
            '<a href="/product/new" class="btn btn-sm btn-primary" role="button">',
            $content
        );
    }

    public function testProductCreated(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/product/new');
        $form = $crawler->selectButton('save-button')->form();
        $form['product[name]']->setValue(self::PRODUCT_NAME);
        $form['product[description]']->setValue(self::PRODUCT_DESCRIPTION);
        $form['product[price]']->setValue(self::PRODUCT_PRICE);
        $form['product[image]']->setValue(self::PRODUCT_IMAGE);
        $client->submit($form);
        $client->followRedirect();
        $this->entityManager->flush();

        $product = $this->productRepository->findOneBy(['name' => self::PRODUCT_NAME]);

        self::assertEquals(self::PRODUCT_NAME, $product->getName());
        self::assertStringContainsString(
            'Продукт '.self::PRODUCT_NAME.' сохранен',
            $product->getResponse()->getContent()
        );
    }

    public function testProductEdited(): void
    {
        $executor = $this->databaseTool->loadFixtures([ProductFixture::class]);
        $product = $executor->getReferenceRepository()->getReference(ProductFixture::getReferenceKey(random_int(1, 3)));

        $client = static::createClient();
        $crawler = $client->request('GET', "/product/{$product->getId()}/edit");
        $form = $crawler->selectButton('save-button')->form();
        $form['product[name]']->setValue(self::PRODUCT_NAME_EDITED);
        $form['product[description]']->setValue(self::PRODUCT_DESCRIPTION_EDITED);
        $form['product[price]']->setValue(self::PRODUCT_PRICE_EDITED);
        $form['product[image]']->setValue(self::PRODUCT_IMAGE_EDITED);
        $client->submit($form);
        $client->followRedirect();
        $this->entityManager->clear();

        $productEdited = $this->productRepository->findOneBy(['name' => self::PRODUCT_NAME_EDITED]);

        /* @var Product $productEdited */
        self::assertEquals(self::PRODUCT_NAME_EDITED, $productEdited->getName());
        self::assertEquals(self::PRODUCT_DESCRIPTION_EDITED, $productEdited->getDescription());
        self::assertEquals(self::PRODUCT_PRICE_EDITED, $productEdited->getPrice());
        self::assertEquals(self::PRODUCT_IMAGE_EDITED, $productEdited->getImage());

        self::assertStringContainsString(
            'Продукт '.$productEdited->getName().' обновлена',
            $client->getResponse()->getContent()
        );
    }

    public function testProductDeleted(): void
    {
        $executor = $this->databaseTool->loadFixtures([ProductFixture::class]);
        $product = $executor->getReferenceRepository()->getReference(ProductFixture::getReferenceKey(random_int(1, 3)));

        $client = static::createClient();
        $crawler = $client->request('GET', "/product/{$product->getId()}/edit");
        $form = $crawler->selectButton('delete-button')->form();
        $client->submit($form);
        $client->followRedirect();

        self::assertStringContainsString('Продукт удален', $client->getResponse()->getContent());
    }
}