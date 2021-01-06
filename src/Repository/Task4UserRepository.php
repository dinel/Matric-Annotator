<?php

namespace App\Repository;

use App\Entity\Task4User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Task4User|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task4User|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task4User[]    findAll()
 * @method Task4User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Task4UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task4User::class);
    }

    // /**
    //  * @return Task4User[] Returns an array of Task4User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Task4User
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
