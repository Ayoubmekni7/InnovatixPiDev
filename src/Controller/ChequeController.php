<?php

namespace App\Controller;

use App\Entity\Cheque;
use App\Form\ChequeType;
use App\Repository\ChequeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChequeController extends AbstractController
{
    #[Route('/addcheques', name: 'addcheques')]
    public function addcheques(ChequeRepository $chequeRepository, Request $request, ManagerRegistry $managerRegistry): Response
    {
        $cheque = new Cheque();
        $form = $this->createForm(ChequeType::class, $cheque);
        $em = $managerRegistry->getManager();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($cheque);
            $em->flush();
            return new Response('ajout avec succes');
        }

        return $this->render('cheque/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/AfficherDemande', name: 'AfficherDemande')]
     public function AfficherDemande(ChequeRepository $chequeRepository):Response

    {
        $liste= $chequeRepository->findAll();
        return $this->render('cheque/list.html.twig',[
            'cheques'=>$liste,
        ]);
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
        return new Response("modification avec succes");

    }
    return $this->renderForm('cheque/add.html.twig',[
        'form' => $form
    ]);
}








}
