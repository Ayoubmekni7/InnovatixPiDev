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
        return $this->render('BaseFront.html.twig', [
            'controller_name' => 'ActualiteController',
        ]);
    }
    #[Route('/dashbordEmploye', name: 'app_dashbordEmploye')]
    public function indexdashbordE(): Response
    {
        return $this->render('Employe/baseEmploye.html.twig', [
            'controller_name' => 'ActualiteController',
        ]);
    }
    #[Route('/dashbordClient', name: 'app_dashbordClient')]
    public function indexdashbordC(): Response
    {
        return $this->render('Employe/baseclient.html.twig', [
            'controller_name' => 'ActualiteController',
        ]);
    }
}
