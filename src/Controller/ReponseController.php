<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReponseController extends AbstractController
{
    #[Route('/reponse', name: 'app_reponse')]
    public function reponse(): Response
    {
        return $this->render('reponse/listeReponseRec.html.twig', [
            'controller_name' => 'ReponseController',
        ]);
    }
}
