<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\Customer;

use App\Product\Domain\Entity\Customer;
use App\Product\Domain\Repository\CustomerRepositoryInterface;
use App\Tests\Resource\Fixture\CustomerFixture;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomerCRUDTest  extends WebTestCase
{
    private const CUSTOMER_NAME = 'Имя';

    private const CUSTOMER_SURNAME = 'Фамилия';

    private const CUSTOMER_NAME_EDITED = 'Новое имя';

    private const CUSTOMER_SURNAME_EDITED = 'Новая фамилия';

    protected function setUp(): void
    {
        $this->customerRepository = static::getContainer()->get(CustomerRepositoryInterface::class);
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        self::ensureKernelShutdown();
    }

    public function testCustomerListDisplayed(): void
    {
        $client = static::createClient();
        $client->request('GET', '/customer');
        $content = $client->getResponse()->getContent();

        self::assertResponseIsSuccessful();
        self::assertStringContainsString('Все покупатели', $content);
        self::assertStringContainsString(
            '<a href="/customer/new" class="btn btn-sm btn-primary" role="button">',
            $content
        );
    }

    public function testCustomerCreated(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/customer/new');
        $form = $crawler->selectButton('save-button')->form();
        $form['customer[name]']->setValue(self::CUSTOMER_NAME);
        $form['customer[surname]']->setValue(self::CUSTOMER_SURNAME);
        $client->submit($form);
        $client->followRedirect();
        $this->entityManager->flush();

        $customer = $this->customerRepository->findOneBy(['name' => self::CUSTOMER_NAME]);

        self::assertEquals(self::CUSTOMER_NAME, $customer->getName());
        self::assertStringContainsString(
            'Покупатель '.self::CUSTOMER_NAME.' сохранен',
            $customer->getResponse()->getContent()
        );
    }

    public function testCustomerEdited(): void
    {
        $executor = $this->databaseTool->loadFixtures([CustomerFixture::class]);
        $customer = $executor->getReferenceRepository()->getReference(CustomerFixture::getReferenceKey(random_int(1, 3)));

        $client = static::createClient();
        $crawler = $client->request('GET', "/customer/{$customer->getId()}/edit");
        $form = $crawler->selectButton('save-button')->form();
        $form['customer[name]']->setValue(self::CUSTOMER_NAME_EDITED);
        $form['customer[surname]']->setValue(self::CUSTOMER_SURNAME_EDITED);
        $client->submit($form);
        $client->followRedirect();
        $this->entityManager->clear();

        $customerEdited = $this->customerRepository->findOneBy(['name' => self::CUSTOMER_NAME_EDITED]);

        /* @var Customer $customerEdited */
        self::assertEquals(self::CUSTOMER_NAME_EDITED, $customerEdited->getName());
        self::assertEquals(self::CUSTOMER_SURNAME_EDITED, $customerEdited->getSurname());

        self::assertStringContainsString(
            'Покупатель '.$customerEdited->getName().' обновлен',
            $client->getResponse()->getContent()
        );
    }

    public function testCustomerDeleted(): void
    {
        $executor = $this->databaseTool->loadFixtures([CustomerFixture::class]);
        $customer = $executor->getReferenceRepository()->getReference(CustomerFixture::getReferenceKey(random_int(1, 3)));

        $client = static::createClient();
        $crawler = $client->request('GET', "/customer/{$customer->getId()}/edit");
        $form = $crawler->selectButton('delete-button')->form();
        $client->submit($form);
        $client->followRedirect();

        self::assertStringContainsString('Покупатель удален', $client->getResponse()->getContent());
    }
}