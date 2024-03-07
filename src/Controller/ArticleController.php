<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Form\EditImgType;

use App\Repository\ArticleRepository;
use App\ServiceReclamation\UploaderServiceRec;
use App\Service\OpenAITextToSpeechService;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/article')]
class ArticleController extends AbstractController

{
    public string $directory = 'uploads_directory_rec';

//    private $openAITextToSpeechService;

//    public function __construct(OpenAITextToSpeechService $openAITextToSpeechService)
//    {
//        $this->openAITextToSpeechService = $openAITextToSpeechService;
//    }
    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }


    #[Route('/newEmpArt', name: 'app_newEmpArt', methods: ['GET', 'POST'])]
    public function newEmpArt(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $managerRegistry ): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        $em = $managerRegistry->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('app_listeArtEmp', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employe/addArticleEmploye.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/listeArtEmp', name: 'app_listeArtEmp', methods: ['GET'])]
    public function listeArtEmp(ArticleRepository $articleRepository): Response
    {
        return $this->render('employe/listeArticlesEmp.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }


    #[Route('/listesarticlefront', name: 'app_listesarticlefront', methods: ['GET'])]
    public function listesarticlefront(ArticleRepository $articleRepository): Response
    {
        // Récupérer les articles de votre base de données
        $articles = $articleRepository->findAll();

        // Récupérer les articles de l'API
        $apiUrl = 'https://rss.app/feeds/v1.1/tVW4ZsKNabUSUsRY.json';
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', $apiUrl);
        $apiArticles = $response->toArray()['items'];



        // Passer les articles fusionnés au rendu du template
        return $this->render('front/listeArticles.html.twig', [
            'articles' => $articles,
            'articlesall'=> $apiArticles,
        ]);
    }

    #[Route('/dashbord', name: 'app_dashbord_admin')]
    public function dashboard(ArticleRepository $articleRepository): Response
    {
        // Récupérer les données de statistiques de likes et dislikes
        $likesDislikesData = $articleRepository->getLikesDislikesStats();

        // Passer les données au rendu du template
        return $this->render('dashbordadmin.html.twig', [
            'likesDislikesData' => $likesDislikesData,
        ]);
    }


    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager , UploaderServiceRec $uploadServiceRec ): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fileRec = $form->get('piecejointeArt')->getData();
            if ($fileRec) {
                $fileName = $uploadServiceRec->uploadFileRec($fileRec);
                $article->setPiecejointeArt($fileName);
            }

            $fileImg = $form->get('imageArt')->getData();
            if ($fileImg) {
                $fileNameImg = $uploadServiceRec->uploadFileRec($fileImg);
                $article->setImageArt($fileNameImg);
            }

            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }







    #[Route('/show/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
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


    #[Route('/articlefront/{id}', name: 'app_articlefront_show', methods: ['GET'])]
    public function articlefront(Article $article): Response
    {
        return $this->render('article/detailArticle.html.twig', [
            'article' => $article,
        ]);
    }
    #[Route('/edit/{id}', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager , UploaderServiceRec $uploadServiceRec ): Response
    {
        $form = $this->createForm(EditImgType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fileRec = $form->get('piecejointeArt')->getData();
            if ($fileRec) {
                $fileName = $uploadServiceRec->uploadFileRec($fileRec);
                $article->setPiecejointeArt($fileName);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }


    #[Route('/delete/{id}', name: 'app_article_delete', methods: ['GET','POST'])]
    public function delete($id , ManagerRegistry $managerRegistry , ArticleRepository $articleRepository): Response
    {

        $entityManager =$managerRegistry->getManager();
        $article= $articleRepository->find($id) ;
        $entityManager->remove($article);
        $entityManager->flush();


        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/deleteEmp/{id}', name: 'app_ArticleEmploye_delete', methods: ['GET','POST'])]
    public function deleteEmp($id , ManagerRegistry $managerRegistry , ArticleRepository $articleRepository): Response
    {

        $entityManager =$managerRegistry->getManager();
        $article= $articleRepository->find($id) ;
        $entityManager->remove($article);
        $entityManager->flush();


        return $this->redirectToRoute('app_listeArtEmp', [], Response::HTTP_SEE_OTHER);
    }



    #[Route('/like/{id}', name: 'app_article_like', methods: ['POST'])]
    public function like(Article $article , UrlGeneratorInterface $urlGenerator): JsonResponse
    {
        $article->setLikes($article->getLikes() + 1);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        $redirectUrl = $urlGenerator->generate('app_dashbord_admin');

        return new JsonResponse(['likes' => $article->getLikes(), 'redirect' => $redirectUrl]);
    }

    #[Route('/dislike/{id}', name: 'app_article_dislike', methods: ['POST'])]
    public function dislike(Article $article): JsonResponse
    {
        $article->setDislikes($article->getDislikes() + 1);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return new JsonResponse(['dislikes' => $article->getDislikes()]);
    }










//    #[Route('/readaloud/{id}', name: 'app_article_read', methods: ['GET'])]
//    // Controller action to convert text to speech
//    public function readAloud(Article $article, OpenAITextToSpeechService $openAITextToSpeechService): Response
//    {
//        // Retrieve the article content
//        $articleContent = $article->getContenuArt();
//
//        // Convert the article content to audio
//        $audio = $openAITextToSpeechService->convertTextToSpeech($articleContent);
//        // Return the audio in the HTTP response with appropriate headers
//        return new Response($audio, 200, [
//            'Content-Type' => 'audio/mpeg',
//        ]);
//    }





}