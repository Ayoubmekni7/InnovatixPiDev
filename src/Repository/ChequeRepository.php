<?php

namespace App\Repository;

use App\Entity\Cheque;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Twilio\Rest\Client;

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
    
    /**
     * @return Cheque[] Returns an array of Cheque objects
     */
    public function HistoriqueDesCheques($value): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.Decision = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            ;
    }
    public function listeDesCheques($value): array
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.Decision = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            ;
    }
    public function listeDesChequesAccepte($value): array
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.Decision = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            ;
    }
    
    public function save(Cheque $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
    
    public function chequeParClient($compte)
    {
        return $this->createQueryBuilder('b')
            ->join('b.compte', 'a')
            ->where('a.compte = :compte')
            ->setParameter('compte', $compte)
            ->getQuery()
            ->getResult();
    }
    
    /**
     * @return Cheque[] Returns an array of Cheque objects
     */
    public function HistoriqueDesChequesParClient($value): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.user = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            ;
    }
    
    public function sms(String $num) : void
    {
        // Your Account SID and Auth Token from twilio.com/console
        $sid = 'AC8aab9f4433d1f7c8dfec3d6b2817b0e2';
        $auth_token = '5f222239c037f19637b25e08389a8aa0';
        // In production, these should be environment variables. E.g.:
        // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]
        // A Twilio number you own with SMS capabilities
        $twilio_number = "+19492696499";
        
        $client = new Client($sid, $auth_token);
        $client->messages->create(
        // the number you'd like to send the message to
            $num,
            [
                // A Twilio phone number you purchased at twilio.com/console
                'from' => $twilio_number,
                // the body of the text message you'd like to send
                'body' => 'Bonjour ' . ', ' .
                    'Nous sommes heureux de vous informer que votre demande de cheque' .
                    'a été approuvée avec succès. Vous pouvez désormais accéder aux fonds transférés. ' .
                    'Cordialement, [ EFB]'
            ]
        );
    }
}