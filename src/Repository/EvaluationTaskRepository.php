<?php

namespace App\Repository;

use App\Entity\EvaluationTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EvaluationTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method EvaluationTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method EvaluationTask[]    findAll()
 * @method EvaluationTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvaluationTaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EvaluationTask::class);
    }

    // /**
    //  * @return EvaluationTask[] Returns an array of EvaluationTask objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EvaluationTask
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
