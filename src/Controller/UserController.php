<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;



#[Route('/user')]
class UserController extends AbstractController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/clients', name: 'app_user_clients', methods: ['GET'])]
    public function listclient(UserRepository $userRepository): Response
    { // Récupérer l'utilisateur actuellement connecté
        
            // Récupérer les utilisateurs avec le rôle 'ROLE_CLIENT'
            $clients = $userRepository->findByRole('ROLE_CLIENT');
    
            return $this->render('user/listclient.html.twig', [
                'users' => $clients,
            ]);
    }
    #[Route('/employes', name: 'app_user_employes', methods: ['GET'])]
    public function listemploye(UserRepository $userRepository): Response
    {
        $employes = $userRepository->findByRole('ROLE_EMPLOYE');
        
        return $this->render('user/listemploye.html.twig', [
            'users' => $employes,
        ]);
    }

    #[Route('/newclient', name: 'app_user_newclient', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_CLIENT']);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_clients', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/newclient.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    
    #[Route('/newemploye', name: 'app_user_newemploye', methods: ['GET', 'POST'])]
    public function newemploye(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_EMPLOYEE']);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_employes', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/newEmploye.html .twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/client/{id}', name: 'app_user_showclient', methods: ['GET'])]
    public function showclient(User $user): Response
    {
        return $this->render('user/showclient.html.twig', [
            'user' => $user,
        ]);
    }
    #[Route('/employe/{id}', name: 'app_user_showemploye', methods: ['GET'])]
    public function showemploye(User $user): Response
    {
        return $this->render('user/showemploye.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/editclient', name: 'app_user_editClient', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('app_user_clients', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('user/editclient.html .twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/{id}/editemploye', name: 'app_user_editEmploye', methods: ['GET', 'POST'])]
    public function editemploye(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_employes', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/editemploye.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('deleteclient/{id}', name: 'app_user_deleteclient', methods: ['GET','POST'])]
    public function deleteClient($id, ManagerRegistry $managerRegistry, UserRepository $userRepository): Response
    {
        $entityManager = $managerRegistry->getManager();
        $employe = $userRepository->find($id);

        if (!$employe) {
            throw $this->createNotFoundException('Client not found');
        }

        $entityManager->remove($employe);
        $entityManager->flush();

        return $this->redirectToRoute('app_user_clients');
    }
    #[Route('/employe/{id}', name: 'app_deleteEmploye', methods: ['GET', 'POST'])]
    public function deleteEmlpoye($id, ManagerRegistry $managerRegistry, UserRepository $userRepository): Response
    {
        $entityManager = $managerRegistry->getManager();
        $employe = $userRepository->find($id);

        if (!$employe) {
            throw $this->createNotFoundException('Employe not found');
        }

        $entityManager->remove($employe);
        $entityManager->flush();

        return $this->redirectToRoute('app_user_employes');
    }
}
