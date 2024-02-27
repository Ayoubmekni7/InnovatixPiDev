<?php

namespace App\Controller;

use App\Service\OpenAIChatService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActualiteController extends AbstractController
{
    #[Route('/actualite', name: 'app_actualite')]
    public function index(): Response
    {
        return $this->render('actualite/index.html.twig', [
            'controller_name' => 'ActualiteController',
        ]);
    }
    #[Route('/dashbordEmploye', name: 'app_dashbordEmploye')]
    public function indexdashbordE(): Response
    {
        return $this->render('Employe/baseEmploye.html.twig', [
            'controller_name' => 'ActualiteController',
        ]);
    }
    #[Route('/dashbordClient', name: 'app_dashbordClient')]
    public function indexdashbordC(): Response
    {
        return $this->render('Employe/baseclient.html.twig', [
            'controller_name' => 'ActualiteController',
        ]);
    }
    #[Route('/chat', name: 'chat')]
    public function chat(Request $request, OpenAIChatService $AIChatService): Response
    {
        $question = $request->request->get('question');
        $response = '';
        
        if ($question) {
            $response = $AIChatService->askQuestion($question);
            dd($response);
        }
        
        
        return $this->render('frontOffice/chat.html.twig', [
            'response' => $response,
        ]);
    }
    
    
}
