<?php

namespace App\Controller;

use App\Form\ChatType;
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
    #[Route('/chat', name: 'chat',methods: ['GET','POST']) ]
    public function chat(Request $request, OpenAIChatService $AIChatService): Response
    
        {
        $answer = null;
        
        $form = $this->createForm(ChatType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $prompt = $form->get('prompt')->getData();
            
            $answer = $AIChatService->getAnswer($prompt);
        }
        
        return $this->render('frontOffice/chat.html.twig', [
            'form' => $form->createView(),
            'answer' => $answer,
        ]);
    }
    
    
}
