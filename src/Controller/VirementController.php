<?php

namespace App\Controller;

use App\Entity\Virement;
use App\Form\VirementType;
use App\Repository\VirementRepository;
use App\Service\uploadFile;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Service\TwilioSmsService;

class VirementController extends AbstractController
{

    public string $directory = 'uploads_directory';

    #[Route('/virements', name: 'app_virement')]
    public function index(): Response
    {
        return $this->render('virement/Virements.html.twig', [
            'controller_name' => 'VirementController',
        ]);
    }

    #[Route('/addvirement', name: 'addvirement')]
    public function addvirement(VirementRepository $virementRepository, Request $request, ManagerRegistry $managerRegistry, SluggerInterface $slugger, uploadFile $uploadFile): Response
    {
        $virement = new Virement ();
        $form = $this->createForm(VirementType::class, $virement);
        $em = $managerRegistry->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->get('photoCinV')->getData();
            $photoCinV = $uploadFile->uploadFile($photo);
            $virement->setPhotoCinV($photoCinV);
            $virement->setDecisionV("encours");
            $em->persist($virement);
            $em->flush();
            return $this->redirectToRoute('historiqueV');
        }

        return $this->render('frontOffice/Client/virement/DemandeVirement.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/showDemande', name: 'showDemande')]
    public function showDemande(VirementRepository $virementRepository): Response
    {
        $liste = $virementRepository->listeDesVirements("encours");
        return $this->render('backoffice/admin/virement/Virements.html.twig', [
            'virements' => $liste,
        ]);

    }

    #[Route('/showHistoriqueV', name: 'showHistoriqueV')]
    public function showHistoriqueV(VirementRepository $virementRepository): Response

    {
        $liste = $virementRepository->listeDesVirementsAccepte("Approuvé");
        return $this->render('backoffice/admin/virement/historiqueVirement.html.twig', [
            'virement' => $liste,
        ]);
    }


    #[Route('/historiqueV', name: 'historiqueV')]
    public function historiqueV(VirementRepository $virementRepository): Response

    {
        $liste = $virementRepository->findAll(true);
        return $this->render('frontOffice/Client/virement/historiqueV.html.twig', [
            'virement' => $liste,
        ]);
    }


    #[Route('/showDemandeE', name: 'showDemandeE')]
    public function showDemandeE(VirementRepository $virementRepository): Response
    {
        $liste = $virementRepository->listeDesVirements("encours ");
        return $this->render('backoffice/Employe/virement/listVirementEmpl.html.twig', [
            'virements' => $liste,
        ]);

    }

    #[Route('/showHistoriqueE', name: 'showHistoriqueE')]
    public function showHistoriqueE(VirementRepository $virementRepository): Response
    {
        $liste = $virementRepository->listeDesVirementsAccepte('Approuvé');
        return $this->render('backoffice/Employe/virement/virementE.html.twig', [
            'virements' => $liste,
        ]);

    }

    #[Route('/ApprouverVirementEmp/{id}', name: 'ApprouverVirementEmp')]
    public function ApprouverVirementEmp($id, ManagerRegistry $managerRegistry, VirementRepository $virementRepository): Response

    {
        $text = "Bonjour.<br>
              Nous sommes heureux de vous informer que votre demande de virement. <br>
               a été approuvée avec succès. Vous pouvez désormais accéder aux fonds transférés. <br>
               Cordialement, [ EFB]";
        $virement = $virementRepository->find($id);
        $virement->setDecisionV("Approuvé");
        $virementRepository->sms('+21628160626',$text);

        $emm = $managerRegistry->getManager();
        $emm->persist($virement);
        $emm->flush();
        return $this->redirectToRoute('showHistoriqueE');
    }

    #[Route('/deleteVirementEmp/{id}', name: 'deleteVirementEmp', methods: ['GET', 'POST'])]
    public function deleteVirementEmp($id, ManagerRegistry $managerRegistry, VirementRepository $virementRepository): Response
    {

        $emm = $managerRegistry->getManager();
        $idremove = $virementRepository->find($id);
        $idremove->setDecisionV('Refuser');
        $emm->persist($idremove);
        $emm->flush();
        return $this->redirectToRoute('showDemandeE');
    }

    #[Route('/deleteVirementAdm/{id}', name: 'deleteVirementAdm', methods: ['GET', 'POST'])]
    public function deleteVirementAdm($id, ManagerRegistry $managerRegistry, VirementRepository $virementRepository): Response
    {
        $text= "Bonjour <br>
               Malheureusement votre demande de Virement a été réfuser.
               <br>
               Cordialement, [ EFB]'";

        $emm = $managerRegistry->getManager();
        $idremove = $virementRepository->find($id);
        $idremove->setDecisionV('Refuser');
        $virementRepository->sms('+21628160626',$text);
        
        $emm->persist($idremove);
        $emm->flush();
        return $this->redirectToRoute('showHistoriqueV');
    }


    #[Route('/ApprouverVirement/{id}', name: 'ApprouverVirement')]
    public function ApprouverVirement($id, ManagerRegistry $managerRegistry , VirementRepository $virementRepository , TwilioSmsService $twilioSmsService ):Response

    {
        $text = "Bonjour.<br>
              Nous sommes heureux de vous informer que votre demande de virement. <br>
               a été approuvée avec succès. Vous pouvez désormais accéder aux fonds transférés. <br>
               Cordialement, [ EFB]";
        $virement=$virementRepository->find($id);
        $virement->setDecisionV("Approuvé");
        $virementRepository->sms('+21628160626',$text);
        $emm=$managerRegistry->getManager();
        $emm->persist($virement);
        $emm->flush();
        return $this->redirectToRoute('showHistoriqueV');
    }
  /*  #[Route('/sendSmsToClient', name: 'sendSmsToClient')]
    public function sendSmsToClient(Request $request, TwilioSmsService $twilioSmsService): Response
    {

        $phoneNumber =$request->request->get('phoneNumber');

        $name=$request->request->get('NometPrenom');

        $text=$request->request->get('text');

        $number_test=$_ENV['+19492696499'];// Numéro vérifier par twilio. Un seul numéro autorisé pour la version de test.

        //Appel du service
        $twilioSmsService->sendSmsToClient($number_test ,$name,$text);

        return $this->render('sms/index.html.twig', ['smsSent'=>true]);
    }*/

    #[Route('/deleteVirement/{id}', name: 'deleteVirement')]
    public function deleteVirement($id, ManagerRegistry $managerRegistry, VirementRepository $virementRepository): Response
    {
        $emm = $managerRegistry->getManager();
        $idremove = $virementRepository->find($id);
        $emm->remove($idremove);
        $emm->flush();
        return $this->redirectToRoute('historiqueV');
    }


    #[Route('/modifierVirement/{id}', name: 'modifierVirement')]
    public function modifierVirement($id, ManagerRegistry $managerRegistry, VirementRepository $virementRepository, Request $request): Response
    {
        $em = $managerRegistry->getManager();
        $idData = $virementRepository->find($id);
        $form = $this->createForm(VirementType::class, $idData);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $em->persist($idData);
            $em->flush();
            return $this->redirectToRoute('historiqueV');

        }
        return $this->renderForm('frontOffice/Client/virement/DemandeVirement.html.twig', [
            'form' => $form
        ]);
    }
}


