<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('baseclient.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/client/dashboard', name: 'app_dashboard')]
    public function index1(): Response
    {
        return $this->render('frontoffice/client/dashboard.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
