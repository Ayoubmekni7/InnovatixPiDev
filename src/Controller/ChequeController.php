<?php

namespace App\Controller;

use App\Entity\Cheque;
use App\Form\ChequeType;
use App\Repository\ChequeRepository;
use App\Service\uploadFile;
use App\Service\YousignService;
use Doctrine\Persistence\ManagerRegistry;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use function MongoDB\BSON\toRelaxedExtendedJSON;
use Symfony\Component\HttpClient\Response\TraceableResponse;


class ChequeController extends AbstractController

{
    /*Client*/


    /* #[Route('/addcheques', name: 'addcheques')]
        public function addcheques(ChequeRepository $chequeRepository, Request $request, ManagerRegistry $managerRegistry , SluggerInterface $slugger , UploadedFile $uploadedFile): Response
        {
            $cheque = new Cheque();
            $form = $this->createForm(ChequeType::class, $cheque);
            $em = $managerRegistry->getManager();
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($cheque);
                $em->flush();
                return $this->redirectToRoute('historique');
            }

            return $this->render('frontoffice/Client/cheque/add.html.twig', [
                'form' => $form->createView()
            ]);
        } */

    #[Route('/historique', name: 'historique')]
    public function historique(ChequeRepository $chequeRepository):Response

    {
        $liste= $chequeRepository->findAll();
        return $this->render('frontOffice/Client/cheque/historique.html.twig',[
            'cheques'=>$liste,
        ]);
    }

    #[Route('/addcheques', name: 'addcheques')]
    public function addcheques(Request $request, ManagerRegistry $managerRegistry, SluggerInterface $slugger, uploadFile $uploadFile): Response
    {
        $cheque = new Cheque();
        $form = $this->createForm(ChequeType::class, $cheque);
        $form->handleRequest($request);


        $subject = "Demande effectuer avec succés";

        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->get('photoCin')->getData();
            $photoCin = $uploadFile->uploadFile($photo);
            $cheque->setPhotoCin($photoCin);
            $cheque->setDecision("encours");
            $x = $managerRegistry->getManager();
            $x->persist($cheque);
            $x->flush();
            return $this->redirectToRoute('historique');
        }

        return $this->render('frontOffice/Client/cheque/add.html.twig', [
            'Cheque'=>$cheque,
            'form' => $form->createView()
        ]);
    }
    #[Route('/AfficherDemande', name: 'AfficherDemande')]
    public function AfficherDemande(ChequeRepository $chequeRepository):Response

    {
        $liste= $chequeRepository->HistoriqueDesCheques(false);
        return $this->render('backoffice/admin/cheque/list.html.twig',[
            'cheques'=>$liste,
        ]);
    }

    #[Route('/showListeCheque', name: 'showListeCheque')]
    public function showListeCheque(ChequeRepository $chequeRepository):Response
    {
        $cheque= $chequeRepository->HistoriqueDesCheques(true);
        return $this->render('backoffice/admin/cheque/historiqueAdmin.html.twig',[
            'cheques'=>$cheque,
        ]);
    }
    #[Route('/AfficherDemandeE', name: 'AfficherDemandeE')]
    public function AfficherDemandeE(ChequeRepository $chequeRepository):Response

    {
        $liste= $chequeRepository->HistoriqueDesCheques(false);
        return $this->render('backoffice/Employe/cheque/listE.html.twig',[
            'cheques'=>$liste,
        ]);
    }

    #[Route('/showListeChequeE', name: 'showListeChequeE')]
    public function showListeChequeE(ChequeRepository $chequeRepository):Response

    {
        $cheque= $chequeRepository->HistoriqueDesCheques(true);
        return $this->render('backoffice/Employe/cheque/listCheque.html.twig',[
            'cheques'=>$cheque,
        ]);
    }



    #[Route('/pdfCheque/{id}', name: 'pdfCheque')]
    public function pdfCheque($id, Request $request, Cheque $cheque ,ChequeRepository $chequeRepository): Response

    {
        $cheque = $chequeRepository->find($id);
        $dompdf = new Dompdf();
        $html = $this->renderView('frontOffice/Client/cheque/pdf.html.twig', [
            'i' => $cheque,
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $output = $dompdf->output();
        $filename = 'cheque_' . $cheque->getId() . '.pdf';
        $file = $this->getParameter('kernel.project_dir') . '/public/' . $filename;

        $cheque->setpdfSansSignature($filename);
        $chequeRepository->save($cheque , true);

        file_put_contents($file, $output);
        return $this->redirectToRoute('showCheque', ['id' => $cheque->getId()]);
        //return $this->render('frontoffice/Client/cheque/pdf.html.twig', [

         //   'i' => $cheque,
       // ]);

    }

    #[Route('/showCheque/{id}', name: 'showCheque')]
    public function showCheque( $id, ChequeRepository $chequeRepository):Response

    {
        $liste= $chequeRepository->find($id);
        return $this->render('frontOffice/Client/cheque/show.html.twig',[
            'i'=>$liste,
        ]);
    }



    #[Route('/signature/{id}', name: 'signature')]
    public function signature($id,  Cheque  $cheque, ChequeRepository $chequeRepository,YousignService $yousignService):Response
    {
        $cheque = $chequeRepository->find($id);

        $cheminFichier = $this->getParameter('cheque').'/'.$cheque->getPdfSansSignature();
        $yousignSignatureRequest= $yousignService->signatureRequest();
        $filename = $cheque->getPdfSansSignature();
        $id = $yousignSignatureRequest['id'];

        $cheque->setSignerId($id);
        $chequeRepository->save ($cheque , true);

        $uploadDocument=$yousignService->addDocumentToSignatureRequest($id , $filename );

       // $cheque->getPdfSansSignature();
       // $cheque->getSignatureId();
         $yesser = $cheque->setDocumentId($uploadDocument['id']);
        $chequeRepository->save ($cheque , true);

        $signerId=$yousignService->addSigner(
            $cheque->getSignerId(),
            $cheque->getDocumentId(),
            $cheque->getEmail(),
            $cheque->getNomPrenom()
        );
        $cheque->setSignerId($signerId['id']);
        $chequeRepository->save($cheque , true);

        $yousignService->activateSignatureRequest($cheque->getSignatureId());
        return $this->redirectToRoute('showCheque', ['id' => $cheque-> getId ()] , Response:: HTTP_SEE_OTHER);


    }




    #[Route('/deleteDemandeChequeClient/{id}', name: 'deleteDemandeChequeClient')]
    public function deleteDemandeChequeClient($id, ManagerRegistry $managerRegistry, ChequeRepository $chequeRepository, $repository):Response
    {
        $emm=$managerRegistry->getManager();
        $idremove=$repository->find($id);
        $emm->remove($idremove);
        $emm->flush();
        return $this->redirectToRoute('historique');


    }


                        /*admin*/



    #[Route('/ApprouverCheque/{id}', name: 'ApprouverCheque')]
    public function ApprouverCheque($id, ManagerRegistry $managerRegistry, ChequeRepository $chequeRepository ,Mailing $mailing):Response
    {
        $cheque=$chequeRepository->find($id);
        $cheque->setActionsC(1);
        $emm=$managerRegistry->getManager();
        $emm->persist($cheque);
        $emm->flush();
        $to=$cheque->getEmail();
        $nometprenom=$cheque->getNometprenom();
        $subject="Félicitations";
        $html="<div> Salut {$nometprenom}.<br>votre demande a été accepté .<br>";
        $this->emailService->sendEmail($to,$subject,$html);
        return  $this->redirectToRoute('showListeCheque');
    }


    #[Route('/deleteDemandeCheque/{id}', name: 'deleteDemandeCheque')]
    public function deleteDemandeCheque($id,ManagerRegistry $managerRegistry,ChequeRepository $repository):Response
    {
        $emm=$managerRegistry->getManager();
        $idremove=$repository->find($id);
        $emm->remove($idremove);
        $emm->flush();
        return $this->redirectToRoute('AfficherDemande');


    }



                             /*Employe*/



    #[Route('/ApprouverChequeE/{id}', name: 'ApprouverChequeE')]
    public function ApprouverChequeE($id, ManagerRegistry $managerRegistry, ChequeRepository $chequeRepository):Response
    {
        $cheque=$chequeRepository->find($id);
        $cheque->setActionsC(true);
        $emm=$managerRegistry->getManager();
        $emm->persist($cheque);
        $emm->flush();
        return  $this->redirectToRoute('showListeChequeE');
    }
    #[Route('/deleteDemandeChequeEmp/{id}', name: 'deleteDemandeChequeEmp', methods: ['GET','POST'])]
    public function deleteDemandeChequeEmp($id,ManagerRegistry $managerRegistry,ChequeRepository $repository):Response
    {
        $emm=$managerRegistry->getManager();
        $idremove=$repository->find($id);
         $emm->remove($idremove);
        $emm->flush();
        return $this->redirectToRoute('AfficherDemandeE');

    }


    #[Route('/modifierCheque/{id}', name: 'modifierCheque')]
    public function modifierCheque($id,ManagerRegistry $managerRegistry,ChequeRepository $chequeRepository , Request $request):Response
    {
    $em=$managerRegistry->getManager();
    $idData =$chequeRepository->find($id);
    $form=$this->createForm(ChequeType::class,$idData);
    $form->handleRequest($request);
    if($form->isSubmitted() and $form->isValid()){
        $em->persist($idData);
        $em->flush();
        return $this->redirectToRoute('historique');

    }
    return $this->renderForm('frontOffice/Client/cheque/add.html.twig',[
        'form' => $form
    ]);

    }

    #[Route('/listeChequeParCompte/{compte}', name: 'listeChequeParCompte')]
    public function listeChequeParCompte($id,ChequeRepository $chequeRepository , Request $request):Response
    {

        $idData =$chequeRepository->chequeParClient($id);
        return $this->renderForm('frontOffice/Client/cheque/add.html.twig',[
            'liste' => $idData
        ]);
    }






}

