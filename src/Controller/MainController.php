<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\DemandeStageRepository;
use App\Repository\OffreStageRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/BaseFront.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    
    #[Route('/front', name: 'app_front')]
    public function front(): Response
    {
        return $this->render('frontOffice/offre_stage/recrutement.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
   
}
