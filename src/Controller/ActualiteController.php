<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActualiteController extends AbstractController
{
    #[Route('/actualite', name: 'app_actualite')]
    public function index(): Response
    {
        return $this->render('front/listArticles.html.twig', [
            'controller_name' => 'ActualiteController',
        ]);
    }
    #[Route('/client', name: 'client')]
    public function client(): Response
    {
        return $this->render('employe/reclamationEmploye.html.twig', [
            'controller_name' => 'ActualiteController',
        ]);
    }
    #[Route('/clientall', name: 'clientall')]
    public function clientall(): Response
    {
        return $this->render('front/index.html.twig', [
            'controller_name' => 'ActualiteController',
        ]);
    }
    #[Route('/afficherRecRep', name: 'app_client')]
    public function afficherRecRep(): Response
    {
        return $this->render('client.html.twig', [
            'controller_name' => 'ActualiteController',
        ]);
    }
}
