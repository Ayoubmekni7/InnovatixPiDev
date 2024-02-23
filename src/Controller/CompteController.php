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
                return  $this->render('frontoffice/Client/compte/creerCompte.html.twig',[
            'form' => $form->createView(),
            'Compte'=>$compte
        ]);

    }
    #[Route('/succses', name: 'succses')]
    public function succses(): Response
    {
        return $this->render('frontoffice/Client/compte/succe.html.twig', [
            'controller_name' => 'SuccsesController',
        ]);
    }

    #[Route('/showInfoCompte/{id}', name: 'showInfoCompte')]
    public function showInfoCompte($id, CompteRepository $compteRepository): Response
    {
        $compte = $compteRepository->find($id);

        return $this->render('frontoffice/Client/compte/informationsCompte.html.twig', [
            'compte' => $compte,
        ]);
    }



    #[Route('/afficheCompte', name: 'afficheCompte')]
    public function afficheCompte(CompteRepository $compteRepository ): Response
    {
        $compte=$compteRepository->listeDesCompte(false);
        return $this->render('backoffice/admin/compte/listCompte.html.twig', [
            'comptes' => $compte,
        ]);
    }

    #[Route('/afficheCompteE', name: 'afficheCompteE')]
    public function afficheCompteE(CompteRepository $compteRepository ): Response
    {
        $compte=$compteRepository->findAll();
        return $this->render('backoffice/Employe/compte/historiqueCompteE.html.twig', [
            'comptes' => $compte,
        ]);
    }
    #[Route('/showHistorique', name: 'showHistorique')]
    public function showHistorique(CompteRepository $compteRepository ): Response
    {
        $compte=$compteRepository->listeDesCompte(true);
        return $this->render('backoffice/admin/compte/historiqueCompte.html.twig', [
            'comptes' => $compte,
        ]);
    }
    #[Route('/ApprouveCompte/{id}', name: 'ApprouveCompte')]
    public function ApprouveCompte($id,ManagerRegistry $managerRegistry ,CompteRepository $compteRepository ): Response
    {
        $compte=$compteRepository->find($id);
        $compte->setStatut(1);
        $emm=$managerRegistry->getManager();
        $emm->persist($compte);
        $emm->flush();;
        return $this->redirectToRoute('showHistorique');
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
    return $this->renderForm('frontoffice/Client/compte/creerCompte.html.twig',[
        'form'=>$form
    ]);

}



}

