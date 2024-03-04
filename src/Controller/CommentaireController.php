<?php

namespace App\Controller;
use App\Entity\Investissement;
use App\Form\InvestissementType;
use App\Repository\InvestissementRepository;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commentaire')]
class CommentaireController extends AbstractController
{


    #[Route('/CommentaireAdd/{id}', name: 'app_CommentaireAddd', methods: ['POST'])]
    public function uploadImageAndAddComment($id, Request $request, EntityManagerInterface $entityManager, InvestissementRepository $investissementRepository): Response
    {
        $investissement = $investissementRepository->find($id);
        if (!$investissement) {
            throw $this->createNotFoundException('Investissement not found');
        }
    
        $uploadedFile = $request->files->get('my_image');
        $nomuser = $request->request->get('nomuser');
        $contenu = $request->request->get('contenu');
    
        if ($uploadedFile) {
            $newImgName = uniqid("IMG-", true) . '.' . $uploadedFile->guessExtension();
            $uploadedFile->move($this->getParameter('kernel.project_dir') . '/public/uploads/', $newImgName);
    
            $commentaire = new Commentaire();
            
        $filteredContenu = $this->filterwords($contenu);
        $commentaire->setContenu($filteredContenu);
            $commentaire->setImg($newImgName);
            $commentaire->setInvestissement($investissement);
            $commentaire->setNomuser($nomuser);
            $commentaire->setDateCreation(new \DateTime());
    
            $entityManager->persist($commentaire);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_event', ['id' => $id]);
        }
    
        return $this->render('your_template.html.twig', [
            'error' => 'Failed to upload image'
        ]);
    }


    #[Route('/', name: 'app_commentaire_index', methods: ['GET'])]
    public function index(CommentaireRepository $commentaireRepository): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $commentaireRepository->findAll(),
        ]);
    }
    

    #[Route('/CommentaireAdd/{id}', name: 'app_CommentaireAdd', methods: ['GET', 'POST'])]
    public function CommentaireAdd($id, Request $request, EntityManagerInterface $entityManager, InvestissementRepository $investissementRepository): Response
    {
      
        $investissement = $investissementRepository->find($id);
            if (!$investissement) {
                throw $this->createNotFoundException('investissement not found');
            }
    
    
            $nomuser = $request->request->get('nomuser');
            $contenu = $request->request->get('contenu');
            $dateCreation = new \DateTime($request->request->get('dateCreation'));
    
            $commentaire = new Commentaire();
        $filteredContenu = $this->filterwords($contenu);
        $commentaire->setContenu($filteredContenu);
            $commentaire->setInvestissement($investissement);
            $commentaire->setNomuser($nomuser);
             $commentaire->setDateCreation($dateCreation);
    
            $entityManager->persist($commentaire);
            $entityManager->flush();
    
                return $this->redirectToRoute('app_event', ['id' => $id] , Response::HTTP_SEE_OTHER);
            
        }

    

    #[Route('/new', name: 'app_commentaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('main/eventsweb.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commentaire_show', methods: ['GET'])]
    public function show(Commentaire $commentaire): Response
    {
        return $this->render('commentaire/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commentaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaire/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commentaire_delete', methods: ['POST'])]
    public function delete(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commentaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
    }


    public function filterwords($text)
    {
        $filterWords = array('hate', 'bhim', 'msatek', 'fuck', 'slut', 'fucku');
        $str = "";
        $data = preg_split('/\s+/',  $text);
        foreach($data as $s){
            $g = false;
            foreach ($filterWords as $lib) {
                if($s == $lib){
                    $t = "";
                    for($i =0; $i<strlen($s); $i++) $t .= "&$*$*$&";
                    $str .= $t . " ";
                    $g = true;
                    break;
                }
            }
            if(!$g)
            $str .= $s . " ";
        }
        return $str;
    }
}