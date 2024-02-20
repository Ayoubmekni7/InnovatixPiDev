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
            return $this->redirectToRoute('succses');
            {#return new Response('creation de compte');#}

            }}
                return  $this->render('frontoffice/compte/creerCompte.html.twig',[
            'form' => $form->createView(),
            'Compte'=>$compte
        ]);

    }
    #[Route('/succses', name: 'succses')]
    public function succses(): Response
    {
        return $this->render('frontoffice/compte/succe.html.twig', [
            'controller_name' => 'SuccsesController',
        ]);
    }



    #[Route('/afficheCompte', name: 'afficheCompte')]
    public function afficheCompte(CompteRepository $compteRepository ): Response
    {
        $compte=$compteRepository->findAll();
        return $this->render('backoffice/compte/listCompte.html.twig', [
            'comptes' => $compte,
        ]);
    }
    #[Route('/deleteCompte/{id}', name: 'deleteCompte')]
public function  deleteCompte($id,ManagerRegistry $managerRegistry,CompteRepository $compteRepository):Response
    {
        $emm=$managerRegistry->getManager();
        $idremove=$compteRepository->find($id);
        $emm->remove($idremove);
        $emm->flush();
        return $this->redirectToRoute('afficheCompte');

    }
#[Route('/modifierCompte/{id}', name: 'modifierCompte')]
public function modifierCompte($id,ManagerRegistry $managerRegistry,CompteRepository $compteRepository,Request $request):Response
{
    $em=$managerRegistry->getManager();
    $idData=$compteRepository->find($id);
    $form=$this->createForm(CompteType::class,$idData);
    $form->handleRequest($request);
    if($form->isSubmitted() and $form->isValid()){
        $em->persist($idData);
        $em->flush();
        return  new Response(("Bien modifié"));
    }
    return $this->renderForm('frontoffice/compte/creerCompte.html.twig',[
        'form'=>$form
    ]);

}



}

