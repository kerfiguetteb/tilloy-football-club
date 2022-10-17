<?php

namespace App\Controller\Entraineur;

use App\Entity\Entraineur;
use App\Repository\EntraineurRepository;
use App\Repository\JoueurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/entraineur')]

class EntraineurController extends AbstractController
{
    #[Route('/', name: 'app_entraineur')]
    public function index(EntraineurRepository $entraineurRepository, JoueurRepository $joueurRepository): Response
    {
        
        if ($this->isGranted('ROLE_ENTRAINEUR')) {
            $user = $this->getUser();
            $entraineur = $entraineurRepository->findOneByUser($user);
            $joueurs = $joueurRepository->findByEquipe($entraineur->getEquipe());

        }
        
        return $this->render('entraineur/index.html.twig', [
            'joueurs'=> $joueurs,
        ]);
    }
}
