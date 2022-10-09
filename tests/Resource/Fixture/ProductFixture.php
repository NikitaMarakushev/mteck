<?php

declare(strict_types=1);

namespace App\Tests\Resource\Fixture;

use App\Cards\Domain\Entity\Card;
use App\Product\Domain\Entity\Product;
use App\Tests\Tools\FakerTool;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Generator;


class ProductFixture extends Fixture implements DependentFixtureInterface
{
    use FakerTool;

    public static function getReferenceKey($i): string
    {
        return sprintf('product_%s', $i);
    }

    public function load(ObjectManager $manager): void
    {
        $i = 1;
        foreach ($this->getData() as $item) {
            $product = new Product(
                $item['name'],
                $item['description'],
                $item['price'],
                $item['image'],
            );

            $manager->persist($product);
            $this->addReference(self::getReferenceKey($i), $product);
            $i++;
        }

        $manager->flush();
    }

    private function getData(): Generator
    {
        yield [
            'name' => 'Ноутбук',
            'description' => 'Ноутбук компании teck, модель mt45',
            'price' => 44990.90,
            'image' => '/var/uploads/products/mteckmt45.jpg'
        ];
        yield [
            'name' => 'Планшет',
            'description' => 'Планшет компании teck, модель mtpad45',
            'price' => 34990.90,
            'image' => '/var/uploads/products/mteckmtpad45.jpg'
        ];
        yield [
            'name' => 'Смартфон',
            'description' => 'Смартфон компании teck, модель m5',
            'price' => 24990.90,
            'image' => '/var/uploads/products/mteck5.jpg'
        ];
    }

    public function getDependencies()
    {
        // TODO: Implement getDependencies() method.
    }
}