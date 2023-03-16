<?php

namespace App\Repository;

use App\Entity\Entreef;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Entreef|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entreef|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entreef[]    findAll()
 * @method Entreef[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntreefRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entreef::class);
    }

    // /**
    //  * @return Entreef[] Returns an array of Entreef objects
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
    public function findOneBySomeField($value): ?Entree
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
