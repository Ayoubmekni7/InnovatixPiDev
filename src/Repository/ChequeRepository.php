<?php

namespace App\Repository;

use App\Entity\Cheque;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cheque>
 *
 * @method Cheque|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cheque|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cheque[]    findAll()
 * @method Cheque[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChequeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cheque::class);
    }

//    /**
//     * @return Cheque[] Returns an array of Cheque objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Cheque
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function chequeParClient($compte)
    {
        return $this->createQueryBuilder('b')
            ->join('b.compte', 'a')
            ->where('a.compte = :compte')
            ->setParameter('compte', $compte)
            ->getQuery()
            ->getResult();
    }
}