<?php

namespace App\Controller;
use App\Entity\Compte;
use App\Form\CompteType;
use App\Repository\CompteRepository;
use App\Service\Mailing;
use Doctrine\Persistence\ManagerRegistry;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3Validator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompteController extends AbstractController
{
    public Mailing $emailService;
    public string $directory = 'uploads_directory';

    public function __construct(Mailing $emailService)
    {
        $this->emailService = $emailService;
    }

    #[Route('/comptes', name: 'app_compte')]
    public function index(): Response
    {
        return $this->render('compte/listCompte.html.twig', [
            'controller_name' => 'CompteController',
        ]);
    }

    #[Route('/createcompte', name: 'createcompte')]
    public function createcompte(CompteRepository $compteRepository, Request $request, ManagerRegistry $managerRegistry, Mailing $mailing): Response
    {
        $compte = new Compte();
        $form = $this->createForm(CompteType::class, $compte);
        $em = $managerRegistry->getManager();
        $form->handleRequest($request);
        $to = $compte->getEmail();
        $nom = $compte->getNom() . '' . $compte->getPrenom();
        $subject = "Demande effectuer avec succés";
        $html = "<div> Bonjour {$nom}.<br>Votre Demande compte .<br>";

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($compte);
            $em->flush();
            $this->emailService->sendEmail($to, $subject, $html);;
            return $this->redirectToRoute('succses');
            {#return new Response('creation de compte');#}
            }
        }
        return $this->render('frontOffice/Client/compte/creerCompte.html.twig', [
            'form' => $form->createView(),
            'Compte' => $compte
        ]);

    }




    #[Route('/succses', name: 'succses')]
    public function succses( Mailing $mailing): Response
    {
        return $this->render('frontOffice/Client/compte/succe.html.twig', [
            'controller_name' => 'SuccsesController',
        ]);
    }


    #[Route('/afficheCompte', name: 'afficheCompte')]
    public function afficheCompte(CompteRepository $compteRepository ): Response
    {
        $compte=$compteRepository->listeDesCompte(false);
        return $this->render('backoffice/admin/compte/listCompte.html.twig', [
            'comptes' => $compte,
        ]);
    }

    #[Route('/afficheCompteE', name: 'afficheCompteE')]
    public function afficheCompteE(CompteRepository $compteRepository ): Response
    {
        $compte=$compteRepository->findAll();
        return $this->render('backoffice/Employe/compte/historiqueCompteE.html.twig', [
            'comptes' => $compte,
        ]);
    }
    #[Route('/showHistorique', name: 'showHistorique')]
    public function showHistorique(CompteRepository $compteRepository ): Response
    {
        $compte=$compteRepository->listeDesCompte(true);
        return $this->render('backoffice/admin/compte/historiqueCompte.html.twig', [
            'comptes' => $compte,
        ]);
    }
    #[Route('/ApprouveCompte/{id}', name: 'ApprouveCompte')]
    public function ApprouveCompte($id, ManagerRegistry $managerRegistry , CompteRepository $compteRepository , Mailing $mailing): Response
    {
        $compte=$compteRepository->find($id);
        $compte->setStatut(1);
        $emm=$managerRegistry->getManager();
        $emm->persist($compte);
        $emm->flush();
        $to =$compte->getEmail();
        $nom =$compte->getNom().$compte->getPrenom();
        $subject = "Compte Créer avec succés";
            $html = "<div>Bonjour {$nom}.<br>Votre Compte a été Créer .<br>";
            $this->emailService->sendEmail($to, $subject, $html);

        return $this->redirectToRoute('showHistorique');
    }

    #[Route('/RefuserCompte/{id}', name: 'RefuserCompte')]
    public function RefuserCompte($id, ManagerRegistry $managerRegistry , CompteRepository $compteRepository , Mailing $mailing): Response
    {
        $compte=$compteRepository->find($id);
        $compte->setStatut(1);
        $emm=$managerRegistry->getManager();
        $emm->persist($compte);
        $emm->flush();
        $to =$compte->getEmail();
        $nom =$compte->getNom().$compte->getPrenom();
        $subject = "Echec";
        $html = "<div>Bonjour {$nom}.<br>Votre Demante a été Réfuser .<br>";
        $this->emailService->sendEmail($to, $subject, $html);

        return $this->redirectToRoute('showHistorique');
    }



    #[Route('/deleteCompte/{id}', name: 'deleteCompte')]
public function  deleteCompte($id,ManagerRegistry $managerRegistry,CompteRepository $compteRepository):Response
    {
        $emm=$managerRegistry->getManager();
        $idremove=$compteRepository->find($id);
        $emm->remove($idremove);
        $emm->flush();
        return $this->redirectToRoute('afficheCompte');

    }
#[Route('/modifierCompte/{id}', name: 'modifierCompte')]
public function modifierCompte($id,ManagerRegistry $managerRegistry,CompteRepository $compteRepository,Request $request):Response
{
    $em=$managerRegistry->getManager();
    $idData=$compteRepository->find($id);
    $form=$this->createForm(CompteType::class,$idData);
    $form->handleRequest($request);
    if($form->isSubmitted() and $form->isValid()){
        $em->persist($idData);
        $em->flush();
        return  new Response(("Bien modifié"));
    }
    return $this->renderForm('frontOffice/Client/compte/creerCompte.html.twig',[
        'form'=>$form
    ]);

}


}

