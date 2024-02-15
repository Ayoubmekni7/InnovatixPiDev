<?php

namespace App\Controller;

use App\Entity\Stage;
use App\Form\StageType;
use App\Repository\StageRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StageController extends AbstractController
{
    #[Route('/stage', name: 'app_stage')]
    public function index(): Response
    {
        return $this->render('stage/index.html.twig', [
            'controller_name' => 'StageController',
        ]);
    }
    #[Route('/createStage', name: 'createStage')]
    public function createStage(Request $request, StageRepository $stageRepository, ManagerRegistry $managerRegistry): Response
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
}
