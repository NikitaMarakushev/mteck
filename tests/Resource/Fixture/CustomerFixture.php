<?php

declare(strict_types=1);

namespace App\Tests\Resource\Fixture;

use App\Product\Domain\Entity\Customer;
use App\Tests\Tools\FakerTool;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Generator;

class CustomerFixture  extends Fixture implements DependentFixtureInterface
{
    use FakerTool;

    public static function getReferenceKey($i): string
    {
        return sprintf('customers_%s', $i);
    }

    public function load(ObjectManager $manager): void
    {
        $i = 1;
        foreach ($this->getData() as $item) {
            $customer = new Customer(
                $item['name'],
                $item['surname'],
            );

            $manager->persist($customer);
            $this->addReference(self::getReferenceKey($i), $customer);
            $i++;
        }

        $manager->flush();
    }

    private function getData(): Generator
    {
        yield [
            'name' => 'Иван',
            'surname' => 'Иванов',
        ];
        yield [
            'name' => 'Петр',
            'description' => 'Петров',
        ];
        yield [
            'name' => 'Константин',
            'description' => 'Константинов',
        ];
    }

    public function getDependencies()
    {
        // TODO: Implement getDependencies() method.
    }
}