<?php

namespace App\Controller;

use App\Entity\Investissement;
use App\Form\InvestissementType;
use App\Repository\InvestissementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/investissement')]
class InvestissementController extends AbstractController
{
    #[Route('/listA', name: 'app_investissement_listA', methods: ['GET'])]
    public function listA(InvestissementRepository $investissementRepository): Response
    {
        return $this->render('investissement/investissements.html.twig', [
            'investissements' => $investissementRepository->findAll(),
        ]);
    }
    #[Route('/listE', name: 'app_investissement_listE', methods: ['GET'])]
    public function listE(InvestissementRepository $investissementRepository): Response
    {
        return $this->render('employe/investissement/investissements.html.twig', [
            'investissements' => $investissementRepository->findAll(),
        ]);
    }
    #[Route('/listC', name: 'app_investissement_listC', methods: ['GET'])]
    public function listC(InvestissementRepository $investissementRepository): Response
    {
        return $this->render('client/investissement/investissements.html.twig', [
            'investissements' => $investissementRepository->findAll(),
        ]);
    }
    #[Route('/new', name: 'app_investissement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $investissement = new Investissement();
        $form = $this->createForm(InvestissementType::class, $investissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($investissement);
            $entityManager->flush();

            return $this->redirectToRoute('app_investissement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('investissement/new.html.twig', [
            'investissement' => $investissement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_investissement_show', methods: ['GET'])]
    public function show(Investissement $investissement): Response
    {
        return $this->render('client/investissement/show.html.twig', [
            'investissement' => $investissement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_investissement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Investissement $investissement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InvestissementType::class, $investissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_investissement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('investissement/edit.html.twig', [
            'investissement' => $investissement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_investissement_delete', methods: ['POST'])]
    public function delete(Request $request, Investissement $investissement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$investissement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($investissement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_investissement_index', [], Response::HTTP_SEE_OTHER);
    }
}
