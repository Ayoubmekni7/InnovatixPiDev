<?php

namespace App\Controller;
use App\Entity\Compte;
use App\Form\CompteType;
use App\Repository\CompteRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompteController extends AbstractController
{
    #[Route('/comptes', name: 'app_compte')]
    public function index(): Response
    {
        return $this->render('compte/listCompte.html.twig', [
            'controller_name' => 'CompteController',
        ]);
    }
    #[Route('/createcompte', name: 'createcompte')]
    public function createcompte(CompteRepository $compteRepository ,Request $request,ManagerRegistry $managerRegistry):Response
    {
        $compte =new Compte();
        $form=$this->createForm(CompteType::class,$compte);
        $em=$managerRegistry->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($compte);
            $em->flush();
            return new Response('creation de compte');

        }
        return  $this->render('compte/creerCompte.html.twig',[
            'form' => $form->createView(),
            'Compte'=>$compte
        ]);

    }

    #[Route('/afficheCompte', name: 'afficheCompte')]
    public function afficheCompte(CompteRepository $compteRepository ): Response
    {
        $compte=$compteRepository->findAll();
        return $this->render('compte/listCompte.html.twig', [
            'comptes' => $compte,
        ]);
    }

}
