<?php

namespace App\Repository;

use App\Entity\France;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method France|null find($id, $lockMode = null, $lockVersion = null)
 * @method France|null findOneBy(array $criteria, array $orderBy = null)
 * @method France[]    findAll()
 * @method France[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FranceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, France::class);
    }

    // /**
    //  * @return France[] Returns an array of France objects
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
    public function findOneBySomeField($value): ?France
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
