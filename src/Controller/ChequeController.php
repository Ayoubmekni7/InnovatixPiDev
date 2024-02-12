<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChequeController extends AbstractController
{
    #[Route('/cheques', name: 'app_cheque')]
    public function index(): Response
    {
        return $this->render('cheque/list.html.twig', [
            'controller_name' => 'ChequeController',
        ]);
    }
}
