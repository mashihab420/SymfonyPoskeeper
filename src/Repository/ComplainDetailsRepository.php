<?php

namespace App\Repository;

use App\Entity\ComplainDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ComplainDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method ComplainDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method ComplainDetails[]    findAll()
 * @method ComplainDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComplainDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComplainDetails::class);
    }

    // /**
    //  * @return ComplainDetails[] Returns an array of ComplainDetails objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ComplainDetails
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
