<?php

namespace App\Repository;

use App\Entity\ContactRelations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ContactRelations|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactRelations|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactRelations[]    findAll()
 * @method ContactRelations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRelationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactRelations::class);
    }

    // /**
    //  * @return ContactRelations[] Returns an array of ContactRelations objects
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
    public function findOneBySomeField($value): ?ContactRelations
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
