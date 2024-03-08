<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Entity\Investissement;
use App\Form\InvestissementType;
use App\Repository\InvestissementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/investissement')]
class InvestissementController extends AbstractController
{
    #[Route('/admin/list', name: 'app_investissement_listA', methods: ['GET'])]
    public function listA(InvestissementRepository $investissementRepository): Response
    {
        return $this->render('admin/investissement/investissements.html.twig', [
            'investissements' => $investissementRepository->findAll(),
        ]);
    }
    #[Route('/employe/list', name: 'app_investissement_listE', methods: ['GET'])]
    public function listE(InvestissementRepository $investissementRepository): Response
    {
        return $this->render('employe/investissement/investissements.html.twig', [
            'investissements' => $investissementRepository->findAll(),
        ]);
    }
    #[Route('/client/list', name: 'app_investissement_listC', methods: ['GET'])]
    public function listC(InvestissementRepository $investissementRepository): Response
    {
        return $this->render('client/investissement/investissements.html.twig', [
            'investissements' => $investissementRepository->findAll(),
        ]);
    }
    
    
    
    #[Route('/admin/new', name: 'app_investissement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $investissement = new Investissement();
        $form = $this->createForm(InvestissementType::class, $investissement);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $security->getUser();
            $investissement->setUser($user);
            
            $entityManager->persist($investissement);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_investissement_listA', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->renderForm('admin/investissement/new.html.twig', [
            'investissement' => $investissement,
            'form' => $form,
        ]);
    }
    
    #[Route('/{id}', name: 'app_investissement_show', methods: ['GET'])]
    public function show(Investissement $investissement): Response
    {
        $project = $investissement->getProject();
        $commentaires = $investissement->getCommentaires();
        $evenements = $investissement->getEvenements(); // Assuming you want to get all Evenements
        $user = $investissement->getUser(); // Assuming there is a method to get the User associated with the Investissement
        
        return $this->render('client/investissement/show.html.twig', [
            
            'project' => $project,
            'investissement' => $investissement,
            'commentaires' => $commentaires,
            'evenements' => $evenements,
            'user' => $user,
        ]);
    }
    
    
    
    
    
    #[Route('create/{id}', name: 'app_investissement_show1', methods: ['GET', 'POST'])]
    public function show1(Request $request, Investissement $investissement, EntityManagerInterface $entityManager): Response
    {
        $commentaires = $investissement->getCommentaires();
        $evenements = $investissement->getEvenements(); // Assuming you want to get all Evenements
        
        $form = $this->createForm(InvestissementType::class, $investissement);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            
            return $this->redirectToRoute('app_investissement_listC', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('client/investissement/create.html.twig', [
            'investissement' => $investissement,
            'commentaires' => $commentaires,
            'evenements' => $evenements,
            'form' => $form->createView(),
        ]);
    }
    
    
    
    
    #[Route('admin/{id}', name: 'app_investissement_showA', methods: ['GET'])]
    public function showA(Investissement $investissement): Response
    {
        $commentaires = $investissement->getCommentaires();
        $evenements = $investissement->getEvenements(); // Assuming you want to get all Evenements
        
        return $this->render('client/investissement/show.html.twig', [
            'investissement' => $investissement,
            'commentaires' => $commentaires,
            'evenements' => $evenements,
        ]);
    }
    
    
    #[Route('/{id}/edit', name: 'app_investissement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Investissement $investissement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InvestissementType::class, $investissement);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            
            return $this->redirectToRoute('app_investissement_listA', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->renderForm('client/investissement/create.html.twig', [
            'investissement' => $investissement,
            'form' => $form,
        ]);
    }
    
    #[Route('/investissement/delete/{id}', name: 'app_investissement_delete', methods: ['GET', 'POST'])]
    public function delete($id, EntityManagerInterface $entityManager, InvestissementRepository $investissementRepository): Response
    {
        $investissement = $investissementRepository->find($id);
        $entityManager->remove($investissement);
        $entityManager->flush();
        return $this->redirectToRoute('app_investissement_listA', [], Response::HTTP_SEE_OTHER);
    }
    
    
}