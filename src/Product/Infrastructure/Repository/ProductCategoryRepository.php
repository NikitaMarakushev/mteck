<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Repository;

use App\Product\Domain\Repository\ProductCategoryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Product\Domain\Entity\ProductCategory;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductCategory[] findAll()
 * @method ProductCategory[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductCategoryRepository extends ServiceEntityRepository implements ProductCategoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductCategory::class);
    }

    public function add(ProductCategory $productCategory): void
    {
        $this->_em->persist($productCategory);
        $this->_em->flush();
    }

    public function update(ProductCategory $edition): void
    {
        $this->_em->persist($edition);
        $this->_em->flush();
    }

    public function remove(ProductCategory $deletion): void
    {
        $this->_em->remove($deletion);
        $this->_em->flush();
    }
}