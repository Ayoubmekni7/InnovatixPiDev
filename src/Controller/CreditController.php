<?php

namespace App\Controller;
use App\Entity\Credit;

use App\Repository\CreditRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CreditType ;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreditController extends AbstractController
{
    #[Route('/credit', name: 'app_credit')]
    public function index(): Response
    {
        return $this->render('credit/index.html.twig', [
            'controller_name' => 'CreditController',
        ]);

    }

    #[Route('/listecredit', name: 'app_listecredit')]
    public function listeacredit(CreditRepository $creditRepository): Response
    {
        $credits=$creditRepository->findAll();
    
        return $this->render('credit/listecredit.html.twig',["credits"=>$credits]);
    }

    #[Route('/listerdv', name: 'app_listerdv')]
    public function listerdv(): Response
    {
        return $this->render('credit/listerdv.html.twig', [
            'controller_name' => 'ActualiteController',
        ]);
    }
    #[Route('/ajoutercredit', name: 'app_ajoutercredit')]
    public function ajoutercredit(ManagerRegistry $doctrine,Request $request):Response{
        $credit=new Credit();
        $form=$this->createForm(CreditType::class,$credit);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->persist($credit);
            $em->flush();
            return $this->redirectToRoute('app_listecredit');
        }
        return $this->render('credit/ajoutercredit.html.twig',[
            'form' => $form->createView(),
        ]);
}}
