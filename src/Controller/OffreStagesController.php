<?php

namespace App\Controller;

use App\Entity\OffreStage;
use App\Form\OffreStageType;
use App\Form\SearchType;
use App\Repository\DemandeStageRepository;
use App\Repository\OffreStageRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OffreStagesController extends AbstractController
{
    #[Route('/Recrutement', name: 'Recrutement')]
    public function Recrutement(OffreStageRepository $offreStageRepository): Response
    {
        $search = [];
        $form = $this->createForm(SearchType::class,$search);
        $liste = $offreStageRepository->findAll();
        return $this->render('frontOffice/offre_stage/recrutement.html.twig',[
            'offres' => $liste,
            'form' => $form->createView()
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
    
    
    #[Route('/addOffre', name: 'addOffre')]
    public function addOffre(ManagerRegistry $managerRegistry,Request $request): Response
    {
        $offre = new OffreStage();
        $form = $this->createForm(OffreStageType::class,$offre);
        $form->handleRequest($request);
        $em = $managerRegistry->getManager();
        if($form->isSubmitted() and $form->isValid() ){
          $em->persist($offre);
          $em->flush();
        }
        return $this->render('backOffice/offre_stage/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/editOffre/{id}', name: 'editOffre')]
    public function editOffre($id,ManagerRegistry $managerRegistry,Request $request, OffreStageRepository $offreStageRepository): Response
    {
        $offre = $offreStageRepository->find($id);
        $form = $this->createForm(OffreStageType::class,$offre);
        $form->handleRequest($request);
        $em = $managerRegistry->getManager();
        if($form->isSubmitted() and $form->isValid() ){
            $em->persist($offre);
            $em->flush();
        }
        return $this->render('backOffice/offre_stage/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/deleteOffre/{id}', name: 'deleteOffre')]
    public function deleteOffre($id,ManagerRegistry $managerRegistry,Request $request, OffreStageRepository $offreStageRepository): Response
    {
        $offre = $offreStageRepository->find($id);
        $em = $managerRegistry->getManager();
            $em->remove($offre);
        return new Response("suppression avec succès ");
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
    
    #[Route('/DemandeParOffres/{id}', name: 'DemandeParOffres')]
    public function DemandeParOffres($id, DemandeStageRepository $demandestageRepository): Response
    {
        $offre = $demandestageRepository->findDemandesByOffre($id);
        return $this->render('backOffice/offre_stage/afficheOffreStages.html.twig', [
            'offres'=>$offre
        ]);
    }
    
}
