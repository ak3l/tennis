<?php

namespace App\Repository;

use App\Entity\PlayerDoublesRanking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PlayerDoublesRanking|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayerDoublesRanking|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayerDoublesRanking[]    findAll()
 * @method PlayerDoublesRanking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerDoublesRankingRepository extends ServiceEntityRepository
{
    /**
     * PlayerDoublesRankingRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayerDoublesRanking::class);
    }

    // /**
    //  * @return PlayerDoublesRanking[] Returns an array of PlayerDoublesRanking objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PlayerDoublesRanking
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
