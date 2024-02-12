<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeStageController extends AbstractController
{
    #[Route('/demande/stage', name: 'app_demande_stage')]
    public function index(): Response
    {
        return $this->render('demande_stage/index.html.twig', [
            'controller_name' => 'DemandeStageController',
        ]);
    }
}
