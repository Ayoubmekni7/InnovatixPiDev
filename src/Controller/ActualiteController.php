<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActualiteController extends AbstractController
{
    #[Route('/actualite', name: 'app_actualite')]
    public function index(): Response
    {
        return $this->render('BaseFront.html.twig', [
            'controller_name' => 'ActualiteController',
        ]);
    }
    #[Route('/dashbordEmploye', name: 'app_dashbordEmploye')]
    public function indexdashbordE(): Response
    {
        return $this->render('Employe/baseEmploye.html.twig', [
            'controller_name' => 'ActualiteController',
        ]);
    }
    #[Route('/dashbordClient', name: 'app_dashbordClient')]
    public function indexdashbordC(UserRepository $repository): Response
    {
        $compte = $this->getDoctrine()->getRepository(Compte::class)->findOneBy([]);

        // Assurez-vous que $compte n'est pas null et récupérez le montant total
        $Montant = ($compte !== null) ? $compte->getMontant() : 0;
        $users = $compte->getId();
        $user= $repository->find($users);
        return $this->render('frontOffice/Client/dashboard.html.twig', [
            'Montant' => $Montant ,
            'user'=>$user,
        ]);

    }


    #[Route('/dashbordClientS', name: 'app_dashbordClientS')]
    public function indexdashbordCS(): Response
    {
        $compte = $this->getDoctrine()->getRepository(Compte::class)->findOneBy([]);

        // Assurez-vous que $compte n'est pas null et récupérez le type de compte
        $typeCompte = ($compte !== null) ? $compte->getTypeCompte() : '';

        return $this->render('frontOffice/Client/dashboard.html.twig', [
            'typeCompte' => $typeCompte,
        ]);
    }
}
