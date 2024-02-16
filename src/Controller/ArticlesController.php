<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
   
    
    #[Route('/article', name: 'app_listeArticles')]
    public function listeArticles(): Response
    {
        return $this->render('articles/listeArticles.html.twig', [
            'controller_name' => 'ActualiteController',
        ]);
    }
    #[Route('/showart', name: 'app_showart')]
    public function showart(): Response
    {
        return $this->render('reclamationn/showreclamation.html.twig', [
            'controller_name' => 'ActualiteController',
        ]);
    }
}
