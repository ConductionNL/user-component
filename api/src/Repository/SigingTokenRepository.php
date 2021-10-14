<?php

namespace App\Repository;

use App\Entity\SigningToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SigningToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method SigningToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method SigningToken[]    findAll()
 * @method SigningToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SigingTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SigningToken::class);
    }

    // /**
    //  * @return SigingToken[] Returns an array of SigingToken objects
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
    public function findOneBySomeField($value): ?SigingToken
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
