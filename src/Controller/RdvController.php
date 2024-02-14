<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Form\RdvType ;

use App\Entity\Rdv;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class RdvController extends AbstractController
{
    #[Route('/rdv', name: 'app_rdv')]
    public function index(): Response
    {
        return $this->render('rdv/index.html.twig', [
            'controller_name' => 'RdvController',
        ]);
    }
    #[Route('/ajouterrdv', name: 'app_ajouterrdv')]
    public function ajoutercredit(ManagerRegistry $doctrine,Request $request):Response{
        $rdv=new Rdv();
        $form=$this->createForm(RdvType::class,$rdv);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->persist($rdv);
            $em->flush();
            return $this->redirectToRoute('app_listecredit');
        }
        return $this->render('credit/ajouterrdv.html.twig',[
            'form' => $form->createView(),
        ]);
}
}