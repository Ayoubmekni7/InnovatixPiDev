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
        return $this->render('offre_stages/index.html.twig', [
            'controller_name' => 'OffreStagesController',
        ]);
    }
}
