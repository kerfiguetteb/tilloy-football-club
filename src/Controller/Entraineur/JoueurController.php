<?php

namespace App\Controller\Entraineur;

use App\Entity\Entraineur;
use App\Repository\EntraineurRepository;
use App\Entity\Joueur;
use App\Form\JoueurType;
use App\Repository\JoueurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('entraineur/joueur')]
class JoueurController extends AbstractController
{
    #[Route('/', name: 'entraineur_app_joueur_index', methods: ['GET'])]
    public function index(JoueurRepository $joueurRepository, EntraineurRepository $entraineurRepository,): Response
    {
        if ($this->isGranted('ROLE_ENTRAINEUR')) {
            $user = $this->getUser();
            $entraineur = $entraineurRepository->findOneByUser($user);
            $joueurs = $joueurRepository->findByEquipe($entraineur->getEquipe());

        }
        
        return $this->render('entraineur/joueur/index.html.twig', [
            'joueurs'=> $joueurs,
            'entraineur'=> $entraineur,
        ]);
    }

    #[Route('/new', name: 'entraineur_app_joueur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, JoueurRepository $joueurRepository): Response
    {
        $joueur = new Joueur();
        $form = $this->createForm(JoueurType::class, $joueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $joueurRepository->save($joueur, true);

            return $this->redirectToRoute('app_joueur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entraineur/joueur/new.html.twig', [
            'joueur' => $joueur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'entraineur_app_joueur_show', methods: ['GET'])]
    public function show(Joueur $joueur): Response
    {
        return $this->render('entraineur/joueur/show.html.twig', [
            'joueur' => $joueur,
        ]);
    }

    #[Route('/{id}/edit', name: 'entraineur_app_joueur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Joueur $joueur, JoueurRepository $joueurRepository, EntraineurRepository $entraineurRepository): Response
    {

            $user = $this->getUser();
            $entraineur = $entraineurRepository->findOneByUser($user);

        if ($entraineur->getEquipe() != $joueur->getEquipe()) {
            return $this->redirectToRoute('entraineur_app_joueur_index', [], Response::HTTP_SEE_OTHER);
        }

        $form = $this->createForm(JoueurType::class, $joueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $joueurRepository->save($joueur, true);

            return $this->redirectToRoute('entraineur_app_joueur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entraineur/joueur/edit.html.twig', [
            'joueur' => $joueur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'entraineur_app_joueur_delete', methods: ['POST'])]
    public function delete(Request $request, Joueur $joueur, JoueurRepository $joueurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$joueur->getId(), $request->request->get('_token'))) {
            $joueurRepository->remove($joueur, true);
        }

        return $this->redirectToRoute('entraineur_app_joueur_index', [], Response::HTTP_SEE_OTHER);
    }
}
