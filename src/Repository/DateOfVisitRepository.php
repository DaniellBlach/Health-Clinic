<?php

namespace App\Repository;

use App\Entity\DateOfVisit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DateOfVisit|null find($id, $lockMode = null, $lockVersion = null)
 * @method DateOfVisit|null findOneBy(array $criteria, array $orderBy = null)
 * @method DateOfVisit[]    findAll()
 * @method DateOfVisit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DateOfVisitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DateOfVisit::class);
    }

    // /**
    //  * @return DateOfVisit[] Returns an array of DateOfVisit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DateOfVisit
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
