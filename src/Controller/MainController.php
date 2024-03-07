<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\ArticleRepository;
use App\Repository\EvenementRepository;
use App\Entity\Investissement;
use App\Form\InvestissementType;
use App\Repository\InvestissementRepository;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/BaseFront.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    
    #[Route('/front', name: 'app_front')]
    public function front(): Response
    {
        return $this->render('frontOffice/offre_stage/recrutement.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    
    #[Route('/upload.php', name: 'upload')]
    public function upload(): Response
    {
        return $this->render('main/upload.php', [
            'controller_name' => 'MainController',
        ]);
    }
 
    #[Route('/event', name: 'app_event', methods: ['GET'])]
    public function event(CommentaireRepository $commentaireRepository, InvestissementRepository $investissementRepository, EvenementRepository $evenementRepository): Response
    {
        return $this->render('main/eventsweb.html.twig', [
            'commentaires' => $commentaireRepository->findAll(),
            'investissements' => $investissementRepository->findAll(),
            'evenements' => $evenementRepository->findAll(),
        ]);
    }



  

    #[Route('/client/dashboard', name: 'app_dashboard')]
    public function index1(): Response
    {
        return $this->render('client/dashboard.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
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
