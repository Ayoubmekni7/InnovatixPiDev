<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\AjouterRecType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class ReclamationController extends AbstractController
{
    #[Route('/reclamation', name: 'app_reclamation')]
    public function reclamation(): Response
    {
        return $this->render('reclamation/listeReclamations.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }
    
    #[Route('/ajouterRec', name: 'app_ajouterRec')]
    public function ajouterRec(ManagerRegistry $mr, Request $req):Response
    {
    $rec= new Reclamation();  
    $em=$mr->getManager();             
    $form=$this->createForm(AjouterRecType::class,$rec);                  
    $form->handleRequest($req);    
       if($form->isSubmitted() && $form->isValid()){            
        $em->persist($rec);
        $em->flush();
        return $this->redirectToRoute('app_reclamation');
       }
       return $this->render('reclamation/ajouterRec.html.twig',[
        'form'=>$form->createView()
       ]);
}
}