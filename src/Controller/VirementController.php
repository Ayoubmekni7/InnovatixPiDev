<?php

namespace App\Controller;

use App\Entity\Virement;
use App\Form\VirementType;
use App\Repository\VirementRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VirementController extends AbstractController
{
    #[Route('/virements', name: 'app_virement')]
    public function index(): Response
    {
        return $this->render('virement/Virements.html.twig', [
            'controller_name' => 'VirementController',
        ]);
    }
    #[Route('/addvirement', name: 'addvirement')]
    public function addvirement(VirementRepository $virementRepository, Request $request, ManagerRegistry $managerRegistry): Response
    {
        $virement= new Virement ();
        $form = $this->createForm(VirementType::class,$virement);
        $em = $managerRegistry->getManager();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($virement);
            $em->flush();
            return new Response("shayma");
        }

        return $this->render('virement/DemandeVirement.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
