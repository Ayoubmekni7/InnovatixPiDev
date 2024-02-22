<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/evenement')]
class EvenementController extends AbstractController
{
    #[Route('/admin/events', name: 'app_evenement_eventsA', methods: ['GET'])]
    public function eventsA(EvenementRepository $evenementRepository,ProjectRepository $projectRepository): Response
    {
        return $this->render('admin/evenement/events.html.twig', [
            'evenements' => $evenementRepository->findAll(),
            'projects' => $projectRepository->findAll(),
        ]);
    }
    #[Route('/client/list', name: 'app_evenement_eventsC', methods: ['GET'])]
    public function eventsC(EvenementRepository $evenementRepository,ProjectRepository $projectRepository): Response
    {
        return $this->render('client/evenement/events.html.twig', [
            'evenements' => $evenementRepository->findAll(),
            'projects' => $projectRepository->findAll(),
        ]);
    }
    #[Route('/admin/events', name: 'app_evenement_index', methods: ['GET'])]
    public function index(EvenementRepository $evenementRepository,ProjectRepository $projectRepository): Response
    {
        return $this->render('evenement/events.html.twig', [
            'evenements' => $evenementRepository->findAll(),
            'projects' => $projectRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('admin/{id}', name: 'app_evenement_showA', methods: ['GET'])]
    public function showA(Evenement $evenement): Response
    {
        return $this->render('admin/evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }
    #[Route('client/{id}', name: 'app_evenement_showC', methods: ['GET'])]
    public function showC(Evenement $evenement): Response
    {
        return $this->render('client/evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_delete',  methods: ['GET','POST'])]
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager,EvenementRepository $evenementRepository): Response
    {
    $entityManager =$managerRegistry->getManager();
    $evenement= $evenementRepository->find($id) ;
    $entityManager->remove($evenement);
        $entityManager->flush();

        return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
    }

    


}