<?php

namespace App\Repository;

use App\Entity\PlayerSinglesRanking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PlayerSinglesRanking|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayerSinglesRanking|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayerSinglesRanking[]    findAll()
 * @method PlayerSinglesRanking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerSinglesRankingRepository extends ServiceEntityRepository
{
    /**
     * PlayerSinglesRankingRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayerSinglesRanking::class);
    }

    // /**
    //  * @return PlayerSinglesRanking[] Returns an array of PlayerSinglesRanking objects
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
    public function findOneBySomeField($value): ?PlayerSinglesRanking
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
