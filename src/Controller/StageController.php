<?php

namespace App\Controller;

use App\Entity\Stage;
use App\Form\ContratType;
use App\Form\StageType;
use App\Repository\StageRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StageController extends AbstractController
{
    #[Route('/AfficheStage', name: 'AfficheStage')]
    public function AfficheStage(StageRepository $stageRepository): Response
    {
        $stages = $stageRepository->findAll();
        return $this->render('stage/index.html.twig', [
            'stages' => $stages,
        ]);
    }
    #[Route('/createStage', name: 'createStage')]
    public function createStage(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $stage = new Stage();
        $form = $this->createForm(StageType::class,$stage);
        $form->handleRequest($request);
        $em = $managerRegistry->getManager();
        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($stage);
            $em->flush();
        }
        return $this->render('stage/addStage.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/deleteStage/{id}', name: 'deleteStage')]
    public function deleteStage($id, ManagerRegistry $manager, StageRepository $stageRepository): Response
    {
        $emm = $manager->getManager();
        $idremove = $stageRepository->find($id);
        $emm->remove($idremove);
        $emm->flush();
        return $this->redirectToRoute('AfficheStage');
    }
    #[Route('/modifierStage/{id}', name: 'modifierStage')]
    public function modifierContrat($id, ManagerRegistry $manager, StageRepository $stageRepository, Request $request,): Response
    {
        $emr = $manager->getManager();
        $idData = $stageRepository->find($id);
        $form = $this->createForm(ContratType::class, $idData);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $emr->persist($idData);
            $emr->flush();
            return new Response("update with succcess");
        }
        return $this->renderForm('stage/add.html.twig', [
            'form' => $form
        ]);
    }
    
}
