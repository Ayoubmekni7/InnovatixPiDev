<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenmentController extends AbstractController
{
    #[Route('/events', name: 'app_evenment')]
    public function index(): Response
    {
        return $this->render('evenement/events.html.twig', [
            'controller_name' => 'EvenmentController',
        ]);
    }
}
