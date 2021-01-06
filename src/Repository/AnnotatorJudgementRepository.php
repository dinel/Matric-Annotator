<?php

namespace App\Repository;

use App\Entity\AnnotatorJudgement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AnnotatorJudgement|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnnotatorJudgement|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnnotatorJudgement[]    findAll()
 * @method AnnotatorJudgement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnotatorJudgementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnnotatorJudgement::class);
    }

    // /**
    //  * @return AnnotatorJudgement[] Returns an array of AnnotatorJudgement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AnnotatorJudgement
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
