<?php

namespace App\Controller;

use App\Entity\ActeEtatCivil;
use App\Form\ActeEtatCivilForm;
use App\Repository\ActeEtatCivilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/acte/etat/civil')]
final class ActeEtatCivilController extends AbstractController
{
    #[Route(name: 'app_acte_etat_civil_index', methods: ['GET'])]
    public function index(ActeEtatCivilRepository $acteEtatCivilRepository): Response
    {
        return $this->render('acte_etat_civil/index.html.twig', [
            'acte_etat_civils' => $acteEtatCivilRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_acte_etat_civil_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $acteEtatCivil = new ActeEtatCivil();
        $form = $this->createForm(ActeEtatCivilForm::class, $acteEtatCivil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($acteEtatCivil);
            $entityManager->flush();
            return $this->redirectToRoute('app_acte_etat_civil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('acte_etat_civil/new.html.twig', [
            'acte_etat_civil' => $acteEtatCivil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_acte_etat_civil_show', methods: ['GET'])]
    public function show(ActeEtatCivil $acteEtatCivil): Response
    {
        return $this->render('acte_etat_civil/show.html.twig', [
            'acte_etat_civil' => $acteEtatCivil,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_acte_etat_civil_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ActeEtatCivil $acteEtatCivil, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActeEtatCivilForm::class, $acteEtatCivil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_acte_etat_civil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('acte_etat_civil/edit.html.twig', [
            'acte_etat_civil' => $acteEtatCivil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_acte_etat_civil_delete', methods: ['POST'])]
    public function delete(Request $request, ActeEtatCivil $acteEtatCivil, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$acteEtatCivil->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($acteEtatCivil);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_acte_etat_civil_index', [], Response::HTTP_SEE_OTHER);
    }
}
