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
            return $this->redirectToRoute('historiqueV');
        }

        return $this->render('frontoffice/Client/virement/DemandeVirement.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/showDemande', name: 'showDemande')]
    public function showDemande(VirementRepository $virementRepository):Response {
        $liste=$virementRepository->listeDesVirements(false);
        return $this->render('backoffice/admin/virement/Virements.html.twig',[
            'virements'=>$liste,
        ]);

    }

    #[Route('/showHistoriqueV', name: 'showHistoriqueV')]
    public function showHistoriqueV(VirementRepository $virementRepository):Response

    {
        $liste= $virementRepository->listeDesVirements(true);
        return $this->render('backoffice/admin/virement/historiqueVirement.html.twig',[
            'virement'=>$liste,
        ]);
    }



    #[Route('/historiqueV', name: 'historiqueV')]
    public function historiqueV(VirementRepository $virementRepository):Response

    {
        $liste= $virementRepository->findAll(true);
        return $this->render('frontoffice/Client/virement/historiqueV.html.twig',[
            'virement'=>$liste,
        ]);
    }


    #[Route('/showDemandeE', name: 'showDemandeE')]
    public function showDemandeE(VirementRepository $virementRepository):Response {
        $liste=$virementRepository->findAll();
        return $this->render('backoffice/Employe/virement/listVirementEmpl.html.twig',[
            'virements'=>$liste,
        ]);

    }
    #[Route('/showHistoriqueE', name: 'showHistoriqueE')]
    public function showHistoriqueE(VirementRepository $virementRepository):Response {
        $liste= $virementRepository->listeDesVirements(true);
        return $this->render('backoffice/Employe/virement/virementE.html.twig',[
            'virements'=>$liste,
        ]);

    }
    #[Route('/ApprouverVirementEmp/{id}', name: 'ApprouverVirementEmp')]
    public function ApprouverVirementEmp($id, ManagerRegistry $managerRegistry , VirementRepository $virementRepository):Response

    {
        $virement=$virementRepository->find($id);
        $virement->setActionsV(true);
        $emm=$managerRegistry->getManager();
        $emm->persist($virement);
        $emm->flush();
        return $this->redirectToRoute('showHistoriqueE');
    }

    #[Route('/deleteVirementEmp/{id}', name: 'deleteVirementEmp')]
    public function deleteVirementEmp($id,ManagerRegistry $managerRegistry,VirementRepository $virementRepository):Response
    {
        $emm=$managerRegistry->getManager();
        $idremove=$virementRepository->find($id);
        $emm->remove($idremove);
        $emm->flush();
        return $this->redirectToRoute('showDemandeE');
    }







    #[Route('/ApprouverVirement/{id}', name: 'ApprouverVirement')]
    public function ApprouverVirement($id, ManagerRegistry $managerRegistry , VirementRepository $virementRepository):Response

    {
        $virement=$virementRepository->find($id);
        $virement->setActionsV(1);
        $emm=$managerRegistry->getManager();
        $emm->persist($virement);
        $emm->flush();
        return $this->redirectToRoute('showHistoriqueV');
    }
    #[Route('/deleteVirement/{id}', name: 'deleteVirement')]
    public function deleteVirement($id,ManagerRegistry $managerRegistry,VirementRepository $virementRepository):Response
    {
        $emm=$managerRegistry->getManager();
        $idremove=$virementRepository->find($id);
        $emm->remove($idremove);
        $emm->flush();
        return $this->redirectToRoute('historiqueV');
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
            return $this->redirectToRoute('historiqueV');

        }
        return $this->renderForm('frontoffice/Client/virement/DemandeVirement.html.twig',[
            'form'=>$form
        ]);
    }
}
