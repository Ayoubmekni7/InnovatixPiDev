<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
#[Route('/project')]

class ProjectController extends AbstractController
{
    #[Route('/listA', name: 'app_project_admin', methods: ['GET'])]
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('admin/project/projects.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }
    #[Route('/listE', name: 'app_project_listE', methods: ['GET'])]
    public function listE(ProjectRepository $projectRepository): Response
    {
        return $this->render('employe/project/projects.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }
    #[Route('/listC', name: 'app_project_indexclient', methods: ['GET'])]
    public function indexclient(ProjectRepository $projectRepository): Response
    {
        return $this->render('client/project/projects.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }

 
    #[Route('/create', name: 'app_project_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('app_project_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/project/new.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_project_indexshowsA', methods: ['GET'])]
    public function showA(Project $project): Response
    {
        return $this->render('admin/project/show.html.twig', [
            'project' => $project,
        ]);
    }
    
    

    #[Route('/{id}/edit', name: 'app_project_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_project_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/project/edit.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

#[Route('delete/{id}', name: 'app_project_delete', methods: ['GET','POST'])]
    public function delete($id , ManagerRegistry $managerRegistry , ProjectRepository $projectRepository): Response
    {
        $entityManager =$managerRegistry->getManager();
        $project= $projectRepository->find($id) ;
        $entityManager->remove($project);
            $entityManager->flush();
        return $this->redirectToRoute('app_project_admin', [], Response::HTTP_SEE_OTHER);
    }

}
