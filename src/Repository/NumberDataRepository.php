<?php

namespace App\Repository;

use App\Entity\NumberData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NumberData|null find($id, $lockMode = null, $lockVersion = null)
 * @method NumberData|null findOneBy(array $criteria, array $orderBy = null)
 * @method NumberData[]    findAll()
 * @method NumberData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NumberDataRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NumberData::class);
    }


    // /**
    //  * @return NumberData[] Returns an array of NumberData objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NumberData
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
