<?php

namespace App\Controller;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
 
    #[Route('/event', name: 'app_event', methods: ['GET'])]
    public function event(CommentaireRepository $commentaireRepository): Response
    {
        return $this->render('main/eventsweb.html.twig', [
            'commentaires' => $commentaireRepository->findAll(),
        ]);
    }
  

    #[Route('/client/dashboard', name: 'app_dashboard')]
    public function index1(): Response
    {
        return $this->render('client/dashboard.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
