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
        return $this->render('actualite/index.html.twig', [
            'controller_name' => 'ActualiteController',
        ]);
    }
    #[Route('/dashbord', name: 'app_dashbord')]
    public function indexdashbord(): Response
    {
        return $this->render('dashbord/index-2.html.twig', [
            'controller_name' => 'ActualiteController',
        ]);
    }
}
