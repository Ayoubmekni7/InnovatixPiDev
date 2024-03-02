<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }
   
    #[Route('/front/{id}', name: 'app_article_showfront', methods: ['GET'])]
    public function showfront(Article $article): Response
    {
        $commentaires = $article->getCommentaire();

        return $this->render('front/detailArticle.html.twig', [
            'article' => $article,
           
            'commentaires' => $commentaires,
        ]);
    }
   
    #[Route('/listesarticlefront', name: 'app_listesarticlefront', methods: ['GET'])]
 public function listesarticlefront(ArticleRepository $articleRepository): Response
 {
     $articles = $articleRepository->findAll();
     return $this->render('front/listeArticles.html.twig', [
         'articles' => $articles,
     ]);
 }


    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager ): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
     
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }
   

    #[Route('/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }
    #[Route('/articlefront/{id}', name: 'app_articlefront_show', methods: ['GET'])]
    public function articlefront(Article $article): Response
    {
        return $this->render('article/detailArticle.html.twig', [
            'article' => $article,
        ]);
    }
    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('delete/{id}', name: 'app_article_delete', methods: ['GET','POST'])]
    public function delete($id , ManagerRegistry $managerRegistry , ArticleRepository $articleRepository): Response
    {
       
            $entityManager =$managerRegistry->getManager();
            $article= $articleRepository->find($id) ;
            $entityManager->remove($article);
            $entityManager->flush();
     

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }


    

  
}
