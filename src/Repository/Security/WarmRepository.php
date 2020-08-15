<?php

namespace App\Repository\Security;

use App\Entity\Security\Warm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Warm|null find($id, $lockMode = null, $lockVersion = null)
 * @method Warm|null findOneBy(array $criteria, array $orderBy = null)
 * @method Warm[]    findAll()
 * @method Warm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WarmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Warm::class);
    }

    // /**
    //  * @return Warm[] Returns an array of Warm objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Warm
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
