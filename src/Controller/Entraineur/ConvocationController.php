<?php

namespace App\Controller\Entraineur;

use App\Entity\Convocation;
use App\Form\ConvocationType;
use App\Repository\ConvocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('entraineur/convocation')]
class ConvocationController extends AbstractController
{
    #[Route('/', name: 'entraineur_app_convocation_index', methods: ['GET'])]
    public function index(ConvocationRepository $convocationRepository): Response
    {
        return $this->render('entraineur/convocation/index.html.twig', [
            'convocations' => $convocationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'entraineur_app_convocation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ConvocationRepository $convocationRepository): Response
    {
        $convocation = new Convocation();
        $form = $this->createForm(ConvocationType::class, $convocation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $convocationRepository->save($convocation, true);

            return $this->redirectToRoute('entraineur_app_convocation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entraineur/convocation/new.html.twig', [
            'convocation' => $convocation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'entraineur_app_convocation_show', methods: ['GET'])]
    public function show(Convocation $convocation): Response
    {
        return $this->render('entraineur/convocation/show.html.twig', [
            'convocation' => $convocation,
        ]);
    }

    #[Route('/{id}/edit', name: 'entraineur_app_convocation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Convocation $convocation, ConvocationRepository $convocationRepository): Response
    {
        $form = $this->createForm(ConvocationType::class, $convocation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $convocationRepository->save($convocation, true);

            return $this->redirectToRoute('entraineur_app_convocation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entraineur/convocation/edit.html.twig', [
            'convocation' => $convocation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'entraineur_app_convocation_delete', methods: ['POST'])]
    public function delete(Request $request, Convocation $convocation, ConvocationRepository $convocationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$convocation->getId(), $request->request->get('_token'))) {
            $convocationRepository->remove($convocation, true);
        }

        return $this->redirectToRoute('entraineur_app_convocation_index', [], Response::HTTP_SEE_OTHER);
    }
}
