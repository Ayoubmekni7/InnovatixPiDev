<?php

namespace App\Controller;

use App\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ArticleRepository;


class MainController extends AbstractController
{
    //#[Route('/main', name: 'app_main')]
    //public function index(): Response
    //{
    //    return $this->render('front/listeArticles.html.twig', [
      //      'articles' => 'MainController',
        //]);
    //}
    #[Route('/frontVisiteur', name: 'frontVisiteur', methods: ['GET'])]

    public function frontVisiteur(ArticleRepository $articleRepository): Response 
    {
        $articles = $articleRepository->findThreeArticles();
        return $this->render('front/index.html.twig', [
            'articles' => $articles,
        ]);
        
    }
    
    
    #[Route('/articles', name: 'app_articles_index', methods: ['GET'])]
    public function articles(ArticleRepository $articleRepository): Response
    {
        return $this->render('front/listeArticles.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

}
