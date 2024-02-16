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
            return new Response('demande avec sucees ');
        }

        return $this->render('virement/DemandeVirement.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/showDemande', name: 'showDemande')]
    public function showDemande(VirementRepository $virementRepository):Response {
        $liste=$virementRepository->findAll();
        return $this->render('virement/Virements.html.twig',[
            'virements'=>$liste,
        ]);

    }
    #[Route('/deleteVirement/{id}', name: 'deleteVirement')]
    public function deleteVirement($id,ManagerRegistry $managerRegistry,VirementRepository $virementRepository):Response
    {
        $emm=$managerRegistry->getManager();
        $idremove=$virementRepository->find($id);
        $emm->remove($idremove);
        $emm->flush();
        return $this->redirectToRoute('showDemande');
    }
    #[Route('/modifierVirement/{id}', name: 'modifierVirement')]
    public function modifierVirement($id,ManagerRegistry $managerRegistry,VirementRepository $virementRepository,Request $request):Response
    {
        $em=$managerRegistry->getManager();
        $idData=$virementRepository->find($id);
        $form=$this->createForm(VirementType::class,$idData);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $em->persist($idData);
            $em->flush();
            return new Response('Modifier avec sucees ');

        }
        return $this->renderForm('virement/DemandeVirement.html.twig',[
            'form'=>$form
        ]);
    }
}
