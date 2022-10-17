<?php

namespace App\Controller;

use App\Entity\Joueur;
use App\Repository\JoueurRepository;
use App\Entity\Equipe;
use App\Repository\EquipeRepository;
use App\Entity\Entraineur;
use App\Repository\EntraineurRepository;
use App\Entity\Game;
use App\Repository\GameRepository;
use App\Entity\Convocation;
use App\Repository\ConvocationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $test = 'Bismilah';

        dump($test);

        $repository = $doctrine->getRepository(Joueur::class);
        $joueurs = $repository->findAll();
        // dump($joueurs);

        $repository = $doctrine->getRepository(Game::class);
        $games = $repository->findAll();
        $game = $repository->find(6);
        // dump($games);
        // dump($game);

        $repository = $doctrine->getRepository(Convocation::class);
        // recuperer les convocation du match tfc vs oaf 
        
        $convocations = $repository->findByGame($game);
        // dump($convocations);
        // récuperer tout les joueurs convoquer pour le match tfc oaf
        $joueursConvoquer= [];
        foreach ($convocations as $convocation) {
            $joueursConvoquer[] = $convocation->getJoueur();
        }
        // dump($joueursConvoquer);
        
        $convocations = $repository->findAll();
        // dump($convocations);
        
        // recuperer l'entraineur et les joueur de l'equipe senior A de tilloy
        $equipeName = 'TILLOY FC';
        $categorieName = 'Senior';
        $groupeName = 'A';
        $repository = $doctrine->getRepository(Equipe::class);
        $tfcSeniorA = $repository->findByNomGroupeCategorie($equipeName,$categorieName,$groupeName);
        dump($tfcSeniorA[0]->getId());
        $tfcSeniorAId= $tfcSeniorA[0]->getId();
        $repository = $doctrine->getRepository(Entraineur::class);
        $entraineur = $repository->findByEquipe($tfcSeniorAId);
        dump($entraineur[0]->getUser());

        // $user = new User;
        // $user->setEmail('entraineur@example.com');
        // $user->setRoles(['ROLE_USER']);
        // $password = $this->hasher->hashPassword($user, '123');
        // $user->setPassword($password);

        // $manager->persist($user);
        // $manager->flush();

        // $entraineur->setUser($user);

        // $manager->persist($entraineur);
        // $manager->flush();


        $repository = $doctrine->getRepository(Joueur::class);
        $joueurs = $repository->findByEquipe($tfcSeniorAId);
        dump($joueurs);

        
        exit();

    }
}
