<?php

namespace App\Controller;
use App\Entity\Credit;
use App\Repository\CreditRepository;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CreditType ;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Email;


class CreditController extends AbstractController
{
    #[Route('/credit', name: 'app_credit')]
    public function index(): Response
    {
        return $this->render('credit/index.html.twig', [
            'controller_name' => 'CreditController',
        ]);

    }

    #[Route('/listecredit', name: 'app_listecredit')]
    public function listeacredit(CreditRepository $creditRepository): Response
    {
        $credits=$creditRepository->findAll();
    
        return $this->render('credit/listecredit.html.twig',["credits"=>$credits]);
    }
    #[Route('/suivrecredit', name: 'app_suivrecredit')]
    public function suivrecredit(CreditRepository $creditRepository): Response
    {
        $credits=$creditRepository->findAll();
    
        return $this->render('credit/suivrecredit.html.twig',["credits"=>$credits]);
    }


    #[Route('/ajoutercredit', name: 'app_ajoutercredit')]
    public function ajoutercredit(ManagerRegistry $doctrine,Request $request):Response{
        $credit=new Credit();
        $form=$this->createForm(CreditType::class,$credit);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->persist($credit);
            $em->flush();
            return $this->redirectToRoute('app_listecredit');
        }
        return $this->render('credit/ajoutercredit.html.twig',[
            'form' => $form->createView(),
        ]);
}

#[Route('/editcredit/{id}', name: 'app_modifiercredit')]
public function modifiercredit(ManagerRegistry $doctrine,$id,CreditRepository $creditRepository,Request $request):Response{
    $credit=$creditRepository->find($id);
    $form=$this->createForm(CreditType::class,$credit);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
        $em=$doctrine->getManager();
        $em->persist($credit);
        $em->flush();
        return $this->redirectToRoute('app_listecredit');
    }
    return $this->render('credit/editcredit.html.twig',[
        'formc' => $form->createView(),
    ]);
}
#[Route('/deletecredit/{id}', name: 'app_deletecredit')]
public function deleteCredit(CreditRepository $creditRepository, ManagerRegistry $doctrine, $id): Response
{
    $credit = $creditRepository->find($id);

    if (!$credit) {
        throw $this->createNotFoundException('Credit not found');
    }

    $em = $doctrine->getManager();
    $em->remove($credit);
    $em->flush();

    return $this->redirectToRoute('app_listecredit');
}

#[Route('/approuvercredit', name: 'app_approuvercredit')]
public function approuvercredit(MailerInterface $mailer): Response
{
    $to = "ahmed.marzougui@esprit.tn";
    $subject = "Email";
    $content = 'hello';
    $email = (new Email())
    ->from('yesser.khaloui@etudiant-fst.utm.tn')
    ->to($to)
    //->cc('cc@example.com')
    //->bcc('bcc@example.com')
    // ->replyTo($this->replyTo)
    //->priority(Email::PRIORITY_HIGH)
    ->subject($subject)
//            ->text('Sending emails is fun again!')
    ->html($content);
    $mailer->send($email);

    return $this->redirectToRoute('app_listecredit');
}
#[Route('/listecreditparid/{id}', name: 'app_recherchecreditid')]
public function listeacreditparid(CreditRepository $creditRepository,$id): Response
{
    $credit=$creditRepository->find($id);

    return $this->render('credit/listecreditv.html.twig',["credit"=>$credit]);
}







}





