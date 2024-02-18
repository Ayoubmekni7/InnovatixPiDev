<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OffreStagesController extends AbstractController
{
    #[Route('/offre/stages', name: 'app_offre_stages')]
    public function index(): Response
    {
        return $this->render('frontOffice/offre_stages/recrutement.html.twig', [
            'controller_name' => 'OffreStagesController',
        ]);
    }
    
    
    
}
