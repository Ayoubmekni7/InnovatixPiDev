<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompteController extends AbstractController
{
    #[Route('/comptes', name: 'app_compte')]
    public function index(): Response
    {
        return $this->render('compte/listCompte.html.twig', [
            'controller_name' => 'CompteController',
        ]);
    }
}
