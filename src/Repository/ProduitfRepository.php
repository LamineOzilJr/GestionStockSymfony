<?php

namespace App\Repository;

use App\Entity\Produitf;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produitf|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produitf|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produitf[]    findAll()
 * @method Produitf[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitfRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produitf::class);
    }

    // /**
    //  * @return Produitf[] Returns an array of Produitf objects
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
    public function findOneBySomeField($value): ?Produit
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
