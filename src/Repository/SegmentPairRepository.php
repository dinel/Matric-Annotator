<?php

namespace App\Repository;

use App\Entity\SegmentPair;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SegmentPair|null find($id, $lockMode = null, $lockVersion = null)
 * @method SegmentPair|null findOneBy(array $criteria, array $orderBy = null)
 * @method SegmentPair[]    findAll()
 * @method SegmentPair[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SegmentPairRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SegmentPair::class);
    }

    // /**
    //  * @return SegmentPair[] Returns an array of SegmentPair objects
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
    public function findOneBySomeField($value): ?SegmentPair
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
