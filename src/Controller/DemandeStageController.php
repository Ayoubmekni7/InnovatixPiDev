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
use Symfony\Component\String\Slugger\SluggerInterface;

class DemandeStageController extends AbstractController
{
    #[Route('/demandeStage', name: 'demandeStage')]
    public function demandeStage(Request $request,ManagerRegistry $managerRegistry,SluggerInterface $slugger): Response
    {
        $demande = new Demandestage();
        $form = $this->createForm(DemandeStageType::class, $demande);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $file =  $form->get('cv')->getData();
     
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
            
            
            $file->move(
                $this->getParameter('uploads_directory'),
                $fileName
            );
            
            
            $demande->setCv($fileName);
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
    public function deleteDemande($id, ManagerRegistry $manager, DemandestageRepository $repo): Response
    {
        $emm = $manager->getManager();
        $idremove = $repo->find($id);
        $emm->remove($idremove);
        $emm->flush();
        return $this->redirectToRoute('demandeStage');
    }
    #[Route('/modifierDemande/{id}', name: 'modifierDemande')]
    public function modifierDemande($id, ManagerRegistry $manager, DemandestageRepository $demandestageRepository, Request $request,): Response
    {
        
        
        $em = $manager->getManager();
        $idData = $demandestageRepository->find($id);
        $form = $this->createForm(DemandeStageType::class, $idData);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $em->persist($idData);
            $em->flush();
            return new Response("update with succcess");
        }
        return $this->renderForm('demande_stage/demande.html.twig', [
            'form' => $form
        ]);
    }
    #[Route('/rechercheDemande/{numero}', name: 'rechercheDemande')]
    public function rechercheDemande($numero, DemandestageRepository $demandestageRepository): Response
    {
        
        $idData = $demandestageRepository->find($numero);
        
        return $this->renderForm('demande_stage/demande.html.twig', [
            'form' => $idData
        ]);
    }
    
    
    
}
