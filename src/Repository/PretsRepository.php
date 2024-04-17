<?php

namespace App\Repository;

use App\Entity\Prets;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Prets>
 *
 * @method Prets|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prets|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prets[]    findAll()
 * @method Prets[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PretsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prets::class);
    }

    //    /**
    //     * @return Prets[] Returns an array of Prets objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Prets
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
