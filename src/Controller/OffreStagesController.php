<?php

namespace App\Controller;

use App\Entity\OffreStage;
use App\Form\OffreStageType;
use App\Form\SearchType;
use App\Repository\DemandeStageRepository;
use App\Repository\OffreStageRepository;
use App\Service\AnalyseCv;
use App\Service\Mailing;
use DateTime;
use DateTimeZone;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OffreStagesController extends AbstractController
{
    public Mailing $emailService;
    public string $directory = 'uploads_directory';
    public function __construct(Mailing $emailService)
    {
        $this->emailService = $emailService;
    }
    #[Route('/Recherche', name: 'Recherche')]
    public function Recherche(DemandeStageRepository $demandeStageRepository,Request $request): Response
    {
        $recherche = $request->get('numero');
        $demande = $demandeStageRepository->Recherche($recherche);
        return $this->render('frontOffice/demande_stage/SearchDemande.html.twig',[
            'Demandes' => $demande,
        ]);
    }
    #[Route('/RechercheDomaine', name: 'RechercheDomaine')]
    public function RechercheDomaine(OffreStageRepository $offreStageRepository,Request $request): Response
    {
        $recherche = $request->get('domaine');
        $demande = $offreStageRepository->findOneBySomeField($recherche);
        return $this->render('frontOffice/offre_stage/recrutement.html.twig',[
            'offres' => $demande,
        ]);
    }
    #[Route('/afficheOffreStages', name: 'afficheOffreStages')]
    public function afficheOffreStages(OffreStageRepository $offreStageRepository): Response
    {
        $liste = $offreStageRepository->findAll();
        return $this->render('backOffice/offre_stage/afficheOffreStages.html.twig',[
            'offres' => $liste,
            
        ]);
    }
    #[Route('/yesserA/{id}', name: 'yesserA')]
    public function yesserYesser($id,DemandeStageRepository $demandeStageRepository,AnalyseCv $cvAnalyseur,OffreStageRepository $offreStageRepository): Response
    {
        $offre = $offreStageRepository->find($id);
        $mots = $offre->getMotsCles();
        $title = $offre->getTitle();
        $listeDemande = $demandeStageRepository->findAll();
        foreach ($listeDemande as $demande) {
            $cheminFichier = $this->getParameter('uploads_directory') . '/' . $demande->getCv();
            $score = $cvAnalyseur->analyseCV($cheminFichier, $mots);
            if ($score < 60) {
                $to = $demande->getEmail();
                $nom = $demande->getNom() . " " . $demande->getPrenom();
                $subject = "Recommondation pour une offre";
                $html = "<div>Bonjour {$nom}.<br>Vous etes recommondé pour l'offre {$title} sous ce chemin  127.0.0.1:8000/DetailsOffre/{$id} .<br>";
                $this->emailService->sendEmail($to, $subject, $html);
            }
        }
        return $this->redirectToRoute("afficheOffreStages");
    }
    
    #[Route('/rechercheOffreStages', name: 'rechercheOffreStages')]
    public function rechercheOffreStages(OffreStageRepository $offreStageRepository,Request $request): Response
    {
        $search = [];
        $form = $this->createForm(SearchType::class,$search);
        $form->handleRequest($request);
        $domaine = $request->get('domaine');
        $liste = $offreStageRepository->findOneBySomeField($domaine);
        return $this->render('frontOffice/offre_stage/recrutement.html.twig',[
            'offres' => $liste,
            'form' => $form->createView(),
        
        ]);
    }
    
    
    #[Route('/addOffre', name: 'addOffre')]
    public function addOffre(ManagerRegistry $managerRegistry,Request $request): Response
    {
                $now = new DateTime('now');
        // Formater le temps réel actuel
       // $nowFormatted = $now->format('Y-m-d H:i:s');
////
////
////
////        // Changer le fuseau horaire à "Europe/Berlin" pendant l'été (Central European Summer Time)
        $now->setTimezone(new DateTimeZone('Europe/Berlin'));
//
//        // Réafficher le temps réel actuel
        $nowFormatted = $now->format('Y-m-d');
        
        $ajouter = "ajouter";
        $ajouterA = "ajouter avec recommandation";
        $offre = new OffreStage();
        $form = $this->createForm(OffreStageType::class,$offre);
        $form->handleRequest($request);
        $em = $managerRegistry->getManager();
        $datePostuObject = DateTime::createFromFormat('Y-m-d', $nowFormatted);
        if($form->isSubmitted() and $form->isValid() ){
            $offre ->setDatePostu($datePostuObject);
          $em->persist($offre);
          $em->flush();
          return $this->redirectToRoute('afficheOffreStages');
        }
        return $this->render('backOffice/offre_stage/add.html.twig', [
            'form' => $form->createView(),
            'ajouter' => $ajouter,
            'ajouterA' => $ajouterA
            
        ]);
    }
    #[Route('/addOffreParRecomendation', name: 'addOffreParRecomendation')]
    public function addOffreParRecomendation(ManagerRegistry $managerRegistry,Request $request): Response
    {
        $now = new DateTime('now');
        // Formater le temps réel actuel
        // $nowFormatted = $now->format('Y-m-d H:i:s');
////
////
////
////        // Changer le fuseau horaire à "Europe/Berlin" pendant l'été (Central European Summer Time)
        $now->setTimezone(new DateTimeZone('Europe/Berlin'));
//
//        // Réafficher le temps réel actuel
        $nowFormatted = $now->format('Y-m-d');
//        $listeDemande = $demandeStageRepository->findAll();
        $ajouter = "ajouter";
        $ajouterA = "ajouter avec recommandation";
        $offre = new OffreStage();
        $form = $this->createForm(OffreStageType::class,$offre);
        $form->handleRequest($request);
        $em = $managerRegistry->getManager();
        $datePostuObject = DateTime::createFromFormat('Y-m-d', $nowFormatted);
//        $mots = $form->get('motsCles')->getData();
        if($form->isSubmitted() and $form->isValid() ){
            
            $offre ->setDatePostu($datePostuObject);
            $em->persist($offre);
            //$title = $offre->getTitle();
            $em->flush();
            $id = $offre->getId();
//            $this->yesserA($id);
            return $this->redirectToRoute('yesserA',[
                'id' => $id
            ]);
        }
        return $this->render('backOffice/offre_stage/add.html.twig', [
            'form' => $form->createView(),
            'ajouter' => $ajouter,
            'ajouterA' => $ajouterA
        ]);
    }
    #[Route('/editOffre/{id}', name: 'editOffre')]
    public function editOffre($id,ManagerRegistry $managerRegistry,Request $request, OffreStageRepository $offreStageRepository): Response
    {
        $modifier = 'modifier';
        $offre = $offreStageRepository->find($id);
        $form = $this->createForm(OffreStageType::class,$offre);
        $form->handleRequest($request);
        $em = $managerRegistry->getManager();
        if($form->isSubmitted() and $form->isValid() ){
            $em->persist($offre);
            $em->flush();
            return $this->redirectToRoute('afficheOffreStages');
        }
        return $this->render('backOffice/offre_stage/add.html.twig', [
            'form' => $form->createView(),
            'ajouter' => $modifier
        ]);
    }
    #[Route('/deleteOffre/{id}', name: 'deleteOffre')]
    public function deleteOffre($id,ManagerRegistry $managerRegistry,Request $request, OffreStageRepository $offreStageRepository): Response
    {
        
        $offre = $offreStageRepository->find($id);
        
        $em = $managerRegistry->getManager();
            $em->remove($offre);
            $em->flush();
        return $this->redirectToRoute("afficheOffreStages");
    }
    #[Route('/DetailsOffre/{id}', name: 'DetailsOffre')]
    public function DetailsOffre($id,ManagerRegistry $managerRegistry,Request $request, OffreStageRepository $offreStageRepository): Response
    {
        $offre = $offreStageRepository->find($id);
        return $this->render('frontOffice/offre_stage/Details.html.twig', [
            'offre'=>$offre
        ]);
    }
    
    #[Route('/ChoixDemaine/{domaine}', name: 'ChoixDemaine')]
    public function ChoixDemaine($domaine, OffreStageRepository $offreStageRepository): Response
    {
        $offre = $offreStageRepository->find($domaine);
        return $this->render('frontOffice/offre_stage/recrutement.html.twig', [
            'offre'=>$offre
        ]);
    }
    #[Route('/Recrutement', name: 'Recrutement')]
    public function Recrutement(OffreStageRepository $offreStageRepository,Request $request,DemandeStageRepository $demandeStageRepository): Response
    {
        $search = [];
        $form = $this->createForm(SearchType::class,$search);
        $form->handleRequest($request);
        $recherche= $request->get('numero');
        $domaine = $request->get('domaine');
        $liste = $offreStageRepository->findAll();
        if ($form ->isSubmitted() && $form->isValid()){
            $id = $recherche;
            return $this->redirectToRoute('rechercheDemande',['numero' =>$id]);
        }
        
        return $this->render('frontOffice/offre_stage/recrutement.html.twig',[
            'offres' => $liste,
            'form' => $form->createView(),
        
        ]);
    }
    #[Route('/DemandeParOffres/{id}', name: 'DemandeParOffres')]
    public function DemandeParOffres($id, DemandeStageRepository $demandestageRepository,OffreStageRepository $offreStageRepository): Response
    {
        $demande = $demandestageRepository->findDemandesByOffre($id);
        $offre = $offreStageRepository->find($id);
        $name = $offre->getTitle();
        return $this->render('backOffice/demande_stage/affichage.html.twig', [
            'Demandes'=>$demande,
            'titre' => $name
        ]);
    }
    #[Route('/DeatailAdmin/{id}', name: 'DeatailAdmin')]
    public function DeatailAdmin($id, OffreStageRepository $offreStageRepository): Response
    {
      //  $demande = $demandestageRepository->findDemandesByOffre($id);
        $offre = $offreStageRepository->find($id);
        $name = $offre->getTitle();
        return $this->render('backOffice/offre_stage/DetailOffreAdmin.html.twig', [
            //'Demandes'=>$demande,
            'titre' => $name,
            'offre' => $offre
        ]);
    }
//    #[Route('/yesserA/{id}', name: 'yesserA')]
//    public function yesserA($id,DemandeStageRepository $demandeStageRepository,AnalyseCv $cvAnalyseur,OffreStageRepository $offreStageRepository): Response
//    {
//        $offre = $offreStageRepository->find($id);
//        $mots = $offre->getMotsCles();
//        $title = $offre->getTitle();
//        $listeDemande = $demandeStageRepository->findAll();
//        foreach ($listeDemande as $demande) {
//            $cheminFichier = $this->getParameter('uploads_directory') . '/' . $demande->getCv();
//            $score = $cvAnalyseur->analyseCV($cheminFichier, $mots);
//            //                dd($score,$id,$demande);
//            if ($score < 50) {
//                $to = $demande->getEmail();
//                $nom = $demande->getNom() . " " . $demande->getPrenom();
//                $subject = "Recommondation pour une offre";
//                $html = "<div>Bonjour {$nom}.<br>Vous etes recommondé pour l'offre {$title} sous ce chemin  127.0.0.1:8000/DetailsOffre/{$id} .<br>";
//                $this->emailService->sendEmail($to, $subject, $html);
//            }
//        }
//        return $this->redirectToRoute("afficheOffreStages");
//    }
    
    
}
