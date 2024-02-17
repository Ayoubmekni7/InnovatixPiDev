<?php

namespace App\Controller;

use App\Entity\Demandestage;
use App\Form\DemandeStageType;
use App\Repository\DemandestageRepository;
use App\Service\Mailing;
use App\Service\uploadFile;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class DemandeStageController extends AbstractController
{
    
    public Mailing $emailService;
    public string $directory = 'uploads_directory';
    public function __construct(Mailing $emailService)
    {
        $this->emailService = $emailService;
    }
    #[Route('/demandeStage', name: 'demandeStage')]
    public function demandeStage(Request $request,ManagerRegistry $managerRegistry,SluggerInterface $slugger): Response
    {
        $demande = new Demandestage();
        $form = $this->createForm(DemandeStageType::class, $demande);
        $form->handleRequest($request);
        $to = $demande->getEmail();
        $nom = $demande->getNom().$demande->getPrenom();
        $subject = "Demande effectuer avec succés";
        $html ="<div>Bonjour {$nom}.<br>Votre Demande a été effectuer avec succès  .<br>";
        if($form->isSubmitted() && $form->isValid()){
            $file =  $form->get('cv')->getData();
     
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
            
            
            $file->move(
                $this->getParameter($this->directory),
                $fileName
            );
            
            
            $demande->setCv($fileName);
            $x = $managerRegistry->getManager();
            $x->persist($demande);
            $x->flush();
            $this->emailService->sendEmail($to,$subject,$html);
        }
        
        return $this->render('frontOffice/demande_stage/demande.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/AffichageDesDemandes', name: 'AffichageDesDemandes')]
    public function AffichageDesDemandes(DemandestageRepository $demandestageRepository): Response
    {
        $liste = $demandestageRepository->findAll();
        return $this->render('backOffice/demande_stage/affichage.html.twig', [
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
        $to = $idremove->getEmail();
        $nom = $idremove->getNom().$idremove->getPrenom();
        $subject = "Demande effectuer avec succés";
        $html ="<div>Bonjour {$nom}.<br>Votre suppression de candidature est effectué avec succès  .<br>";
        $this->emailService->sendEmail($to,$subject,$html);
        return $this->redirectToRoute('demandeStage');
    }
    #[Route('/modifierDemande/{id}', name: 'modifierDemande')]
    public function modifierDemande($id, ManagerRegistry $manager, DemandestageRepository $demandestageRepository, Request $request, UploadFile $uploaderService): Response
    {
        $em = $manager->getManager();
        $idData = $demandestageRepository->find($id);
        $ancienCv = $idData->getCv();
        $idData->setCv(Null);
        $form = $this->createForm(DemandeStageType::class, $idData);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() and $form->isValid()) {
            $cv = $form->get('cv')->getData();
            if($cv) {
                $idData->setCv($uploaderService->uploadFile($cv,'uploads_directory'));
            }else{
                $idData->setCv($ancienCv);
            }
            
            $em->persist($idData);
            $em->flush();
            $to = $idData->getEmail();
            $nom = $idData->getNom().$idData->getPrenom();
            $subject = "Demande effectuer avec succés";
            $html ="<div>Bonjour {$nom}.
                    <div>
                    <br>Votre modification de candidature est effectué avec succès  .<br>
                    </div>";
            $this->emailService->sendEmail($to,$subject,$html);
            return new Response("update with succcess");
        }
        return $this->renderForm('frontOffice/demande_stage/edit.html.twig', [
            'form' => $form,
            'ancienCv'=> $ancienCv,
        ]);
    }
    
    #[Route('/rechercheDemande/{numero}', name: 'rechercheDemande')]
    public function rechercheDemande($numero, DemandestageRepository $demandestageRepository): Response
    {
        
        $idData = $demandestageRepository->find($numero);
        
        return $this->renderForm('frontOffice//demande_stage/demande.html.twig', [
            'form' => $idData
        ]);
    }
}
