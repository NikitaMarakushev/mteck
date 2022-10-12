<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Repository;

use App\Product\Domain\Entity\Customer;
use App\Product\Domain\Repository\CustomerRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[] findAll()
 * @method Customer[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository  extends ServiceEntityRepository implements CustomerRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    public function add(Customer $customer): void
    {
        $this->_em->persist($customer);
        $this->_em->flush();
    }

    public function update(Customer $edition): void
    {
        $this->_em->persist($edition);
        $this->_em->flush();
    }

    public function remove(Customer $deletion): void
    {
        $this->_em->remove($deletion);
        $this->_em->flush();
    }
}