<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreditController extends AbstractController
{
    #[Route('/credit', name: 'app_credit')]
    public function index(): Response
    {
        return $this->render('credit/index.html.twig', [
            'controller_name' => 'CreditController',
        ]);

    }

    #[Route('/listecredit', name: 'app_listecredit')]
    public function listeacredit(): Response
    {
        return $this->render('credit/listecredit.html.twig', [
            'controller_name' => 'ActualiteController',
        ]);
    }

    #[Route('/listerdv', name: 'app_listerdv')]
    public function listerdv(): Response
    {
        return $this->render('credit/listerdv.html.twig', [
            'controller_name' => 'ActualiteController',
        ]);
    }
}
