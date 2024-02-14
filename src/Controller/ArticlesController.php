<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
   
    
    #[Route('/listeArticles', name: 'app_listeArticles')]
    public function listeArticles(): Response
    {
        return $this->render('articles/listeArticles.html.twig', [
            'controller_name' => 'ActualiteController',
        ]);
    }
}
