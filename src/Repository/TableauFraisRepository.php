<?php

namespace App\Repository;

use App\Entity\TableauFrais;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TableauFrais|null find($id, $lockMode = null, $lockVersion = null)
 * @method TableauFrais|null findOneBy(array $criteria, array $orderBy = null)
 * @method TableauFrais[]    findAll()
 * @method TableauFrais[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TableauFraisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TableauFrais::class);
    }

    // /**
    //  * @return TableauFrais[] Returns an array of TableauFrais objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TableauFrais
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
