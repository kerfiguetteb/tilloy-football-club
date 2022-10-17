<?php

namespace App\Controller\Admin;

use App\Entity\Entraineur;
use App\Form\EntraineurType;
use App\Repository\EntraineurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/entraineur')]
class AdminEntraineurController extends AbstractController
{
    #[Route('/', name: 'app_admin_entraineur_index', methods: ['GET'])]
    public function index(EntraineurRepository $entraineurRepository): Response
    {
        return $this->render('admin/entraineur/index.html.twig', [
            'entraineurs' => $entraineurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_entraineur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntraineurRepository $entraineurRepository): Response
    {
        $entraineur = new Entraineur();
        $form = $this->createForm(EntraineurType::class, $entraineur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entraineurRepository->save($entraineur, true);

            return $this->redirectToRoute('app_admin_entraineur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/entraineur/new.html.twig', [
            'entraineur' => $entraineur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_entraineur_show', methods: ['GET'])]
    public function show(Entraineur $entraineur): Response
    {
        return $this->render('admin/entraineur/show.html.twig', [
            'entraineur' => $entraineur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_entraineur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Entraineur $entraineur, EntraineurRepository $entraineurRepository): Response
    {
        $form = $this->createForm(EntraineurType::class, $entraineur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entraineurRepository->save($entraineur, true);

            return $this->redirectToRoute('app_admin_entraineur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/entraineur/edit.html.twig', [
            'entraineur' => $entraineur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_entraineur_delete', methods: ['POST'])]
    public function delete(Request $request, Entraineur $entraineur, EntraineurRepository $entraineurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entraineur->getId(), $request->request->get('_token'))) {
            $entraineurRepository->remove($entraineur, true);
        }

        return $this->redirectToRoute('app_admin_entraineur_index', [], Response::HTTP_SEE_OTHER);
    }
}
