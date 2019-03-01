<?php

namespace App\Repository;

use App\Entity\SmsStat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SmsStat|null find($id, $lockMode = null, $lockVersion = null)
 * @method SmsStat|null findOneBy(array $criteria, array $orderBy = null)
 * @method SmsStat[]    findAll()
 * @method SmsStat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SmsStatRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SmsStat::class);
    }

    public function clearTable(){

        $conn = $this->getEntityManager()->getConnection();

        $sql = 'TRUNCATE `sms`.`sms_stat`';

        $stmt = $conn->prepare($sql);
        $stmt->execute();

    }

    public function selectFromMax($start){

        $qd = $this
            ->createQueryBuilder('p')
            ->where('p.id > :start')
            ->setParameter('start', $start)
            ->getQuery()
        ;
        return $qd->execute();

    }

    // /**
    //  * @return SmsStat[] Returns an array of SmsStat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SmsStat
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
