<?php

namespace App\Repository;

use App\Entity\Compte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Compte>
 *
 * @method Compte|null find($id, $lockMode = null, $lockVersion = null)
 * @method Compte|null findOneBy(array $criteria, array $orderBy = null)
 * @method Compte[]    findAll()
 * @method Compte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Compte::class);
    }

   /**
    * @return Compte[] Returns an array of Compte objects
    */
   public function listeDesCompte($value): array
   {
       return $this->createQueryBuilder('c')
           ->andWhere('c.statut = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getResult()
       ;
   }
    /**
     * @return Compte[] Returns an array of Compte objects
     */


   public function findOneBySomeField($value): ?Compte
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
          ->getOneOrNullResult() ;
   }
}
