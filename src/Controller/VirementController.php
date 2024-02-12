<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VirementController extends AbstractController
{
    #[Route('/virements', name: 'app_virement')]
    public function index(): Response
    {
        return $this->render('virement/Virements.html.twig', [
            'controller_name' => 'VirementController',
        ]);
    }
}
