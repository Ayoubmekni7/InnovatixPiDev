<?php

namespace App\Repository;

use App\Entity\Demandestage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Demandestage>
 *
 * @method Demandestage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Demandestage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Demandestage[]    findAll()
 * @method Demandestage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandestageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Demandestage::class);
    }

//    /**
//     * @return Demandestage[] Returns an array of Demandestage objects
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

//    public function findOneBySomeField($value): ?Demandestage
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
