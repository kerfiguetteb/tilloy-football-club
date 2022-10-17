<?php

namespace App\Controller\Entraineur;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use App\Entity\Domicile;
use App\Repository\DomicileRepository;
use App\Entity\Convocation;
use App\Repository\ConvocationRepository;
use App\Entity\Entraineur;
use App\Repository\EntraineurRepository;
use App\Entity\Equipe;
use App\Repository\EquipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;


#[Route('entraineur/game')]
class GameController extends AbstractController
{
    #[Route('/', name: 'entraineur_app_game_index', methods: ['GET'])]
    public function index(GameRepository $gameRepository): Response
    {
        return $this->render('entraineur/game/index.html.twig', [
            'games' => $gameRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'entraineur_app_game_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'entraineur_app_game_edit', methods: ['GET', 'POST'])]

    public function new(Request $request, Game $game = null, Domicile $domicile = null,
     GameRepository $gameRepository, 
    DomicileRepository $domicileRepository,
    EntraineurRepository $entraineurRepository,
    EquipeRepository $equipeRepository): Response
    {
        if ($this->isGranted('ROLE_ENTRAINEUR')) {
            $user = $this->getUser();
            $entraineur = $entraineurRepository->findOneByUser($user);
            $categorie=$entraineur->getEquipe()->getCategorie();
            
        }
        $equipesEntraineur = $equipeRepository->findByCategorie($categorie);
        
        if (!$game || !$domicile) {
            $game = new Game();
            $domicile = new Domicile();
            # code...
        }
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);
        $formEquipe = $this->createFormBuilder($domicile)
            ->add('equipe',ChoiceType::class,[
                'choices'=>[$equipesEntraineur],
                'choice_label' => function($equipesEntraineur) {
                    return "{$equipesEntraineur->getNom()} ({$equipesEntraineur->getGroupe()})";
                },
                ])
            ->getForm();
        $formEquipe->handleRequest($request);

        if ($formEquipe->isSubmitted() && $formEquipe->isValid()) {
            $idEquipe=$formEquipe->getData()->getEquipe();
            $domicile->setEquipe($idEquipe);
            $domicileRepository->save($domicile, true);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $game->setDomicile($domicile);
            $gameRepository->save($game, true);

            return $this->redirectToRoute('entraineur_app_game_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('entraineur/game/new.html.twig', [
            'game' => $game,
            'form' => $form,
            'formEquipe' => $formEquipe,
            'editMode' => $game->getId() !== null 
        ]);
    }

    #[Route('/{id}', name: 'entraineur_app_game_show', methods: ['GET'])]
    public function show(Game $game, ConvocationRepository $convocationRepository): Response
    {
        $convocations = $game->getConvocations();
        return $this->render('entraineur/game/show.html.twig', [
            'game' => $game,
            'convocations'=>$convocations
        ]);
    }

    // #[Route('/{id}/edit', name: 'entraineur_app_game_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Game $game, GameRepository $gameRepository): Response
    // {
    //     $form = $this->createForm(GameType::class, $game);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $gameRepository->save($game, true);

    //         return $this->redirectToRoute('entraineur_app_game_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('entraineur/game/edit.html.twig', [
    //         'game' => $game,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}', name: 'entraineur_app_game_delete', methods: ['POST'])]
    public function delete(Request $request, Game $game, GameRepository $gameRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$game->getId(), $request->request->get('_token'))) {
            $gameRepository->remove($game, true);
        }

        return $this->redirectToRoute('entraineur_app_game_index', [], Response::HTTP_SEE_OTHER);
    }
}
