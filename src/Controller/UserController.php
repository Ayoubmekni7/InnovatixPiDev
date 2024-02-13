<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/listclient', name: 'app_listclient')]
    public function listclient(): Response
    {
        return $this->render('user/listclient.html.twig', [
            'controller_name' => 'ActualiteController',
        ]);
    }
    #[Route('/listemploye', name: 'app_listemploye')]
    public function listemploye(): Response
    {
        return $this->render('user/listemploye.html.twig', [
            'controller_name' => 'ActualiteController',
        ]);}
        #[Route('/ajoute', name: 'app_ajoute')]
    
    
    #[Route('/ajoutemploye', name: 'app_ajoutemploye')]
    public function ajoutemploye(): Response
    {
        return $this->render('user/addemploye.html.twig', [
            'controller_name' => 'ActualiteController',
        ]); 
    } 
    #[Route('/ajoutclient', name: 'app_ajoutclient')]
    public function ajoutclient(): Response
    {
        return $this->render('user/addclient.html.twig', [
            'controller_name' => 'ActualiteController',
        ]); 
    } 
   
}
