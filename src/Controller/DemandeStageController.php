<?php

namespace App\Controller;

use App\Entity\Demandestage;
use App\Form\DemandeStageType;
use App\Repository\DemandestageRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class DemandeStageController extends AbstractController
{
    #[Route('/demandeStage', name: 'demandeStage')]
    public function demandeStage(Request $request,ManagerRegistry $managerRegistry): Response
    {
        $demande = new Demandestage();
        $form = $this->createForm(DemandeStageType::class, $demande);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $x = $managerRegistry->getManager();
            $x->persist($demande);
            $x->flush();
        }
        return $this->render('demande_stage/demande.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/AffichageDesDemandes', name: 'AffichageDesDemandes')]
    public function AffichageDesDemandes(DemandestageRepository $demandestageRepository): Response
    {
        $liste = $demandestageRepository->findAll();
        return $this->render('demande_stage/affichage.html.twig', [
            'Demandes' => $liste,
        ]);
    }
    
    #[Route('/deleteDemande/{id}', name: 'deleteDemande')]
    public function deleteDemande($id, ManagerRegistry $manager, DemandestageRepository $repo,MailerInterface $mailer): Response
    {
        $emm = $manager->getManager();
        $idremove = $repo->find($id);
        $emm->remove($idremove);
        $emm->flush();
        return $this->redirectToRoute('demandeStage');
    }
    
    
    
    
}