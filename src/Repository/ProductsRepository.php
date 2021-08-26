<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface; 

/**
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends ServiceEntityRepository
{
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Products::class);
        $this -> paginator =  $paginator;
    }

    
    public function allProduits()
    {
        $queryBuilder = $this->createQueryBuilder('p');
        $queryBuilder ->select('count(p.id) as value');
            
        return $queryBuilder->getQuery()->getOneOrNullResult() 
        ;
    }


    public function findWithSearch(SearchData $data)
    {
        $query = $this
            ->createQueryBuilder('p')
            // ->select('c', 'p')
            ->join('p.category', 'c')
            ->join('p.fashion', 'm');

        if (!empty($data->category)) {
            $query = $query
                ->andWhere('c.id IN (:category)')
                ->setParameter('category', $data->category);
        }

        if (!empty($data->fashion)) {
            $query = $query
                ->andWhere('m.id IN (:fashion)')
                ->setParameter('fashion', $data->fashion); 
        }

        if (!empty($data->string)) {
            $query = $query
                ->andWhere('p.name LIKE :string')
                ->setParameter('string', "%{$data->string}%");
        }

        $query=$query->getQuery()->getResult();
        return $this -> paginator ->paginate(
            $query, /* query NOT result */
            $data->page, /*page number*/  
            // $request->query->getInt('page', 1)
            9 /*limit per page*/);
    }

    // /**
    //  * @return Products[] Returns an array of Products objects
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
    public function findOneBySomeField($value): ?Products
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
