<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/reclamation')]
class ReclamationController extends AbstractController
{
    #[Route('/', name: 'app_reclamation_index', methods: ['GET'])]
    public function index(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }

    #[Route('/showRecEmploye', name: 'app_showRecEmploye_index', methods: ['GET'])]
    public function showRecEmploye(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('employe/reclamationEmploye.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }
   
    #[Route('/reclamationClient/{id}', name: 'app_reclamation_showId', methods: ['GET'])]
    public function showId($id,ReclamationRepository $reclamationRepository): Response
    {
        $b = $reclamationRepository->findAll();
        $a = $reclamationRepository->findByExampleField($id);
    
        return $this->render('client/reclamation.html.twig', [
            'reclamation' => $a,
        ]);
    }

   

    #[Route('/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_showId', ['id' => $reclamation->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }
    #[Route('/newFront', name: 'app_reclamationFront_new', methods: ['GET', 'POST'])]
    public function newFront(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('clientall
            
            
            
            ', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('front/index.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }
   

    #[Route('/{id}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('delete/{id}', name: 'app_reclamation_delete', methods: ['GET','POST'])]
    public function delete($id , ManagerRegistry $managerRegistry , ReclamationRepository $reclamationRepository): Response
    {
        $entityManager =$managerRegistry->getManager();
        $reclamation= $reclamationRepository->find($id) ;
        $entityManager->remove($reclamation);
            $entityManager->flush();
        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }
    
}
