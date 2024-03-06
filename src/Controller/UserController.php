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
use Knp\Component\Pager\PaginatorInterface;


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
                 // Hachage du mot de passe
        $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        $user->setPassword($hashedPassword);
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
    public function newemploye(Request $request, EntityManagerInterface $entityManager ): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_EMPLOYEE']);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             // Hachage du mot de passe
        $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        $user->setPassword($hashedPassword);
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
                 // Hachage du mot de passe
        $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        $user->setPassword($hashedPassword);
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
                // Hachage du mot de passe
        $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        $user->setPassword($hashedPassword);
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
    #[Route('/searchclient', name: 'searchclient')]
    public function searchUserById(Request $request, UserRepository $userRepository): Response
    {   
        $id = $request->query->get('id');

        // Recherche de l'utilisateur par son identifiant
        $user = $userRepository->searchByIdAndRole($id, ['ROLE_CLIENT']);

        return $this->render('user/listclient.html.twig', [
            'users' => $user,
        ]);
    } 
    //block user by id
    #[Route('/block/{id}', name: 'app_user_block', methods: ['GET', 'POST'])]
    public function block(Request $request, User $user, UserRepository $userRepository): Response
    {
        $user->setIsBlocked(true);
        $userRepository->save($user, true);
       // $user->setEtat("l utlisateur est bloque");
        return $this->redirectToRoute('app_user_clients', [], Response::HTTP_SEE_OTHER);
    }

    //unblock user by id
    #[Route('/unblock/{id}', name: 'app_user_unblock', methods: ['GET', 'POST'])]
    public function unblock(Request $request, User $user, UserRepository $userRepository): Response
    {
        $user->setIsBlocked(false);
        $userRepository->save($user, true);
       // $user->setEtat("l utilisateur est debloque");
        return $this->redirectToRoute('app_user_clients', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/{id}/editAdmin', name: 'app_admin_edit', methods: ['GET', 'POST'])]
    public function editA(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(userType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);
            return $this->redirectToRoute('app_admin_back', [], Response::HTTP_SEE_OTHER);

        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    #[Route('/userStates', name: 'userStates')]
    public function userStates(UserRepository $userRepository): Response
    {
        $countAllUsers = $userRepository->countAll();
        $countAdminUsers = $userRepository->countAdmin();
        $countEmployeUsers = $userRepository->countEmploye();
        $countClientUsers = $userRepository->countClient();
        $countUnBlockedUsers = $userRepository->countUnBlocked();
        $countBlockedUsers = $userRepository->countBlocked();
    
        $userStats = [
            'labels' => ['Admin', 'Employé', 'Client', 'Non bloqués', 'Bloqués'],
            'data' => [
                $countAdminUsers,
                $countEmployeUsers,
                $countClientUsers,
                $countUnBlockedUsers,
                $countBlockedUsers
            ]
        ];
    
        return $this->render('dashbord/dashbordAdmin.html.twig', [
            'userStats' => $userStats,
        ]);
    }
    
    
}
