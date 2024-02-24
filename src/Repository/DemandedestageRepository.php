<?php

namespace App\Repository;

use App\Entity\Demandedestage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Demandedestage>
 *
 * @method Demandedestage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Demandedestage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Demandedestage[]    findAll()
 * @method Demandedestage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandedestageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Demandedestage::class);
    }

//    /**
//     * @return Demandedestage[] Returns an array of Demandedestage objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Demandedestage
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
