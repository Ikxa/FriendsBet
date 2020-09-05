<?php

namespace App\Repository\App;

use App\Entity\App\MatchToBet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MatchToBet|null find($id, $lockMode = null, $lockVersion = null)
 * @method MatchToBet|null findOneBy(array $criteria, array $orderBy = null)
 * @method MatchToBet[]    findAll()
 * @method MatchToBet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchToBetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MatchToBet::class);
    }
    
    public function findAllScheduled()
    {
        return $this->createQueryBuilder('m')
            ->andWhere("m.status LIKE '%SCHEDULED%'")
            ->orderBy('m.played_at', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
        ;
    }

    // /**
    //  * @return Match[] Returns an array of Match objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Match
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
