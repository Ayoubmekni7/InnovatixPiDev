<?php

namespace App\Controller;

//use OpenAI;
use App\Entity\Demandestage;
use App\Repository\DemandeStageRepository;
use App\Repository\OffreStageRepository;
use App\Service\AnalyseCv;
use App\Service\Mailing;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public Mailing $emailService;
    public string $directory = 'uploads_directory';
    public function __construct(Mailing $emailService)
    {
        $this->emailService = $emailService;
    }
    #[Route('/', name: 'app_home')]
    public function index(?string $question, ?string $response): Response
    {
        return $this->render('home/index.html.twig', [
            'question' => $question,
            'response' => $response
        ]);
    }
    
    #[Route('/AnalyseurCvApi/{id}/{cv}', name: 'AnalyseurCvApi', methods:["POST", "GET"])]
    public function AnalyseurCvApi($id, $cv, Request $request, Mailing $mailing, OffreStageRepository $offreStageRepository, AnalyseCv $analyseCv): JsonResponse
    {
        $offre = $offreStageRepository->find($id);
        $cheminFichier = $this->getParameter('uploads_directory').'/'.$cv;
        $score = $analyseCv->analyseCV($cheminFichier, $offre->getMotsCles());
        
        $mailing->sendEmail("khaluiyesser@gmail.com", "test API", "il marche bien");
        
        // Création du tableau contenant le message et le score
        $data = [
            'message' => 'Ceci est un exemple de réponse depuis Symfony',
            'score' => $score
        ];
        
        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }
    #[Route('/Recommandation/{id}', name: 'send_chat', methods:["POST", "GET"])]
    public function Recommandation($id, OffreStageRepository $offreStageRepository, AnalyseCv $analyseCv,DemandeStageRepository $demandeStageRepository): JsonResponse
    {
        $offre = $offreStageRepository->find($id);
//        dd($offre);
        $mots = $offre->getMotsCles();
        $title = $offre->getTitle();
        $listeDemande = $demandeStageRepository->findAll();
//        dd($mots);
        foreach ($listeDemande as $demande) {
            $cheminFichier = $this->getParameter('uploads_directory') . '/' . $demande->getCv();
            $score = $analyseCv->analyseCV($cheminFichier, $mots);
            if ($score > 30) {
                $to = $demande->getEmail();
                $nom = $demande->getNom() . " " . $demande->getPrenom();
                $subject = "Recommondation pour une offre";
                $html = "<div>Bonjour $nom.<br>Vous êtes recommandé pour l'offre $title sous ce chemin <a href='http://127.0.0.1:8000/DetailsOffre/$id'>cliquez ici</a>.<br>";
                $this->emailService->sendEmail($to, $subject, $html);
            }
        }
        $data = [
            'message' => 'Ceci est un exemple de réponse depuis Symfony',
            'score' => "envoi avec succès"
        ];
        
        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }
    #[Route('/mailingRefuser/{email}/{id}', name: 'mailingRefuser', methods:["POST", "GET"])]
    public function mailingRefuser($email,$id,DemandeStageRepository $demandeStageRepository): JsonResponse
    {
        $demande = $demandeStageRepository->find($id);
        $subject = "Malheuresement";
        $nom = $demande->getNom();
        $html ="<div>Bonjour {$nom}.<br>Votre Demande a été réfusé .<br>";
        $this->emailService->sendEmail($email,$subject,$html);
        $data = [
            'message' => 'Ceci est un exemple de réponse depuis Symfony',
            'score' => 2
        ];
        
        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }
    #[Route('/mailingApprouver/{email}/{id}', name: 'mailingApprouver', methods:["POST", "GET"])]
    public function mailingApprouver($email,$id,DemandeStageRepository $demandeStageRepository): JsonResponse
    {
        $demande = $demandeStageRepository->find($id);
        $subject = "Félécitations";
        $nom = $demande->getNom();
        $html ="<div>Bonjour {$nom}.<br>Félécitations votre demande est accepter .<br>";
        $this->emailService->sendEmail($email,$subject,$html);
        $data = [
            'message' => 'Ceci est un exemple de réponse depuis Symfony',
            'score' => 1
        ];
        
        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }
    #[Route('/Mailing/{email}', name: 'mailingApprouver', methods:["POST", "GET"])]
    public function mailing($email,DemandeStageRepository $demandeStageRepository): JsonResponse
    {
//        $demande = $demandeStageRepository->find($id);
        $subject = "Félécitations";
//        $nom = $demande->getNom();
        $html ="<div>Bonjour {$email}.<br>Félécitations votre demande est accepter .<br>";
        
        $this->emailService->sendEmail($email,$subject,$html);
        $data = [
            'message' => 'Ceci est un exemple de réponse depuis Symfony',
            'score' => 1
        ];
        
        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }
}
