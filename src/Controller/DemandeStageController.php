<?php

namespace App\Controller;

use App\Entity\Demandestage;
use App\Form\DemandeStageType;
use App\Repository\DemandeStageRepository;
use App\Repository\OffreStageRepository;
use App\Service\AnalyseCv;
use App\Service\Mailing;
use App\Service\uploadFile;
use DateTime;
use DateTimeZone;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class DemandeStageController extends AbstractController
{
    // la date et temps actuel
   
    public Mailing $emailService;
    public string $directory = 'uploads_directory';
    public function __construct(Mailing $emailService)
    {
        $this->emailService = $emailService;
    }
    #[Route('/AffichageDesDemandes', name: 'AffichageDesDemandes')]
    public function AffichageDesDemandes(DemandeStageRepository $demandestageRepository): Response
  {
            $titre = "La liste des demandes";
            $liste = $demandestageRepository->findByEtat("encours");
////        $now = new DateTime('now');
////        // Formater le temps réel actuel
////        $nowFormatted = $now->format('Y-m-d H:i:s');
////
////
////
////        // Changer le fuseau horaire à "Europe/Berlin" pendant l'été (Central European Summer Time)
////        $now->setTimezone(new DateTimeZone('Europe/Berlin'));
//
//        // Réafficher le temps réel actuel
//        $nowFormatted = $now->format('Y-m-d H:i:s');
        return $this->render('backOffice/demande_stage/affichage.html.twig', [
            'Demandes' => $liste,
            'titre'=> $titre
        ]);
    }
    #[Route('/demandeStage', name: 'demandeStage')]
    public function demandeStage(Request $request,ManagerRegistry $managerRegistry,SluggerInterface $slugger,uploadFile $uploadFile): Response
    {
        $demande = new Demandestage();
        $form = $this->createForm(DemandeStageType::class, $demande);
        $form->handleRequest($request);
        $to = $demande->getEmail();
        $nom = $demande->getNom().' '.$demande->getPrenom();
        
        $subject = "Demande effectuer avec succés";
        $html ="<div>Bonjour {$nom}.<br>Votre Demande a été effectuer avec succès  .<br>";
        $de = $demande->getCv();
        
        if($form->isSubmitted() && $form->isValid()){
            $file =  $form->get('cv')->getData();
            $cv = $uploadFile->uploadFile($file);
            $demande->setCv($cv);
            $demande->setEtat("encours");
            $x = $managerRegistry->getManager();
            $x->persist($demande);
            $x->flush();
            $this->emailService->sendEmail($to,$subject,$html);
            return $this->redirectToRoute('Recrutement');
        }
        
        return $this->render('frontOffice/demande_stage/demande.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/ApprouverDemande/{id}', name: 'ApprouverDemande')]
    public function ApprouverDemande($id,DemandeStageRepository $demandestageRepository,ManagerRegistry $managerRegistry ,Mailing $mailing): Response
    {
        $em =$managerRegistry->getManager();
        $demande = $demandestageRepository->find($id);
        $demande->setEtat("accept");
        $em->persist($demande);
        $em->flush();
        $to = $demande->getEmail();
        $nom = $demande->getNom().$demande->getPrenom();
        $subject = "Félicitations";
        $html ="<div>Bonjour {$nom}.<br>Votre Demande a été accepté .<br>";
        $this->emailService->sendEmail($to,$subject,$html);
        return $this->redirectToRoute('AffichageDesDemandes');
    }
    #[Route('/RefuserDemande/{id}', name: 'RefuserDemande')]
    public function RefuserDemande($id,DemandeStageRepository $demandestageRepository,ManagerRegistry $managerRegistry): Response
    {
        $em =$managerRegistry->getManager();
        $demande = $demandestageRepository->find($id);
        $demande->setEtat("refuse");
        $em->persist($demande);
        $em->flush();
        $to = $demande->getEmail();
        $nom = $demande->getNom().$demande->getPrenom();
        $subject = "Malheuresement";
        $html ="<div>Bonjour {$nom}.<br>Votre Demande a été réfusé .<br>";
        $this->emailService->sendEmail($to,$subject,$html);
        return $this->redirectToRoute('AffichageDesDemandes');
    }
    #[Route('/demandeStageOffre/{id}', name: 'demandeStageOffre')]
    public function demandeStageOffre($id,uploadFile $uploadFile,Request $request,ManagerRegistry $managerRegistry,SluggerInterface $slugger,OffreStageRepository $offreStageRepository): Response
    {
        $offre = $offreStageRepository->find($id);
        $demandeO = new Demandestage();
        $form = $this->createForm(DemandeStageType::class, $demandeO);
        $form->handleRequest($request);
        $to = $demandeO->getEmail();
        $nom = $demandeO->getNom().$demandeO->getPrenom();
        $subject = "Demande effectuer avec succés";
        $html ="<div>Bonjour {$nom}.<br>Votre Demande a été effectuer avec succès  .<br>";
        if($form->isSubmitted() && $form->isValid()){
            $file =  $form->get('cv')->getData();
            $cv = $uploadFile->uploadFile($file);
            $demandeO->setCv($cv);
            $x = $managerRegistry->getManager();
            $demandeO->setOffreStage($offre);
            $demandeO->setEtat("encours");
            $x->persist($demandeO);
            $x->flush();
            $this->emailService->sendEmail($to,$subject,$html);
            return $this->redirectToRoute('Recrutement');
        }
        
        return $this->render('frontOffice/demande_stage/demande.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/deleteDemandeA/{id}/', name: 'deleteDemande')]
    public function deleteDemandeA($id, ManagerRegistry $manager, DemandeStageRepository $repo): Response
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
        return $this->redirectToRoute('AffichageDesDemandes');
    }
    #[Route('/rechercheDemande/{numero}', name: 'rechercheDemande')]
    public function rechercheDemande($numero, DemandeStageRepository $demandestageRepository): Response
    {
        
        $idData = $demandestageRepository->Recherche($numero);
        
        return $this->renderForm('frontOffice/demande_stage/SearchDemande.html.twig', [
            'Demandes' => $idData
        ]);
    }
    #[Route('/deleteDemande/{id}/{numero}', name: 'deleteDemandeOffre')]
    public function deleteDemande($id,$numero, ManagerRegistry $manager, DemandeStageRepository $repo): Response
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
        return $this->redirectToRoute('rechercheDemande',['numero' =>$numero]);
    }
    #[Route('/modifierDemande/{id}/{numero}', name: 'modifierDemande')]
    public function modifierDemande($id,$numero, ManagerRegistry $manager, DemandeStageRepository $demandestageRepository, Request $request, UploadFile $uploaderService): Response
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
            return $this->redirectToRoute('rechercheDemande',['numero' =>$numero]);
        }
        return $this->renderForm('frontOffice/demande_stage/demande.html.twig', [
            'form' => $form,
            'ancienCv'=> $ancienCv,
        ]);
    }
    #[Route('/Analyse', name: 'Analyse')]
    public function Analyse(Request $request, AnalyseCv $cvAnalyseur,DemandeStageRepository $demandeStageRepository): Response
    {
        
        // Récupérer le texte du CV depuis la requête
       // $cvTexte = $request->getContent();
        $champs = $demandeStageRepository->find(14);
        $path = $champs->getCv();
        $cheminFichier = $this->getParameter('uploads_directory').'/'.$path;
        // Liste des mots clés
        $motsCles = ['expérience','Java','kotlin', 'python','XML', 'ingénieur', 'développement', 'programmation', 'analyse', 'réseaux'];
        
        // Appeler le service pour analyser le CV
        $score = $cvAnalyseur->analyseCV($cheminFichier, $motsCles);
        
      
        return new Response("ça marche bien");
    }
}
