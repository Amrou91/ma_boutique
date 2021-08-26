<?php

namespace App\Repository;

use App\Entity\Fashion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Fashion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fashion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fashion[]    findAll()
 * @method Fashion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FashionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fashion::class);
    }

    // /**
    //  * @return Fashion[] Returns an array of Fashion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Fashion
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
