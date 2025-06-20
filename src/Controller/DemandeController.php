<?php

namespace App\Controller;

use App\Entity\ActeEtatCivil;
use App\Entity\Demande;
use App\Form\ActeEtatCivilForm;
use App\Form\DemandeForm;
use App\Repository\ActeEtatCivilRepository;
use App\Repository\DemandeRepository;
use App\Repository\StatusRepository;
use App\Repository\TypeActeRepository;
use App\Utils\Constants\FixedValuesConstants;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/demande')]
final class DemandeController extends AbstractController
{
    public function __construct(
        private TypeActeRepository $typeActeRepository,
        private EntityManagerInterface $manager,
        private ActeEtatCivilRepository $acteEtatCivilRepository,
        private StatusRepository $statusRepository,
        private DemandeRepository $demandeRepository,
    )
    {

    }

    #[Route('/demande_en_attente_traitement', name: 'app_demande_en_attente_traitement', methods: ['GET'])]
    public function demandeEnAttenteTraitement(): Response
    {
        $statusEnAttente = $this->statusRepository->findOneBy(['deleted' => false, 'reference'=> FixedValuesConstants::STATUS_DEMANDE_SOUMISE]);
        $demandesEnAttente = $this->demandeRepository->findBy(['deleted' => false, 'status' => $statusEnAttente]);
        return $this->render('demande/demande_en_attente_traitement.html.twig', [
            'demandes' => $demandesEnAttente
        ]);
    }
    #[Route('/demande_traitee', name: 'app_demande_traitee', methods: ['GET'])]
    public function demandeTraitee(): Response
    {
        $statusEnAttente = $this->statusRepository->findOneBy(['deleted' => false, 'reference'=> FixedValuesConstants::STATUS_DEMANDE_SOUMISE]);
        $statusEnCours = $this->statusRepository->findOneBy(['deleted' => false, 'reference' => FixedValuesConstants::STATUS_DEMANDE_EN_COURS_TRAITEMENT]);
        $demandesTraitees = $this->demandeRepository->findDemandeTraitees( $statusEnAttente, $statusEnCours);
        return  $this->render('demande/demande_traitee.html.twig' ,[
            'demandes' => $demandesTraitees
        ]);
    }

    #[Route('/new', name: 'app_demande_new', methods: ['GET', 'POST'])]
    #[isGranted('ROLE_CONSULAT')]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $demande = new Demande();
        $acteEtatCivil = new ActeEtatCivil();
        $form = $this->createForm(ActeEtatCivilForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
           $acteEtatCivil->setNom($request->get('acte_etat_civil_form')['nom'])
               ->setPrenoms($request->get('acte_etat_civil_form')['prenoms'])
               ->setDateNaissance(new \DateTime($request->get('acte_etat_civil_form')['dateNaissance']))
               ->setNomMere($request->get('acte_etat_civil_form')['nomMere'])
               ->setNomPere($request->get('acte_etat_civil_form')['nomPere'])
               ->setTypeActe($this->typeActeRepository->findOneBy(['deleted'=> false, 'id' => $request->get('acte_etat_civil_form')['typeActe']]))
               ->setLieuNaissance($request->get('acte_etat_civil_form')['lieuNaissance'])
               ->setNumeroActe($request->get('acte_etat_civil_form')['numeroActe'])
               ;
           $copiePdf = $request->files->get('acte_etat_civil_form')['copiePdf'];
            if ($copiePdf) {
                $originalFilename = pathinfo($copiePdf->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $copiePdf->guessExtension();

                $copiePdf->move(
                    $this->getParameter('uploads_directory'),
                    $newFilename
                );
                $acteEtatCivil->setCopiePdf($newFilename);
            }
           //Enregistrement du fichier
           $entityManager->persist($acteEtatCivil);
           $demande->setNumeroActe($acteEtatCivil)
               ->setDateSoumission(new \DateTime('now'))
                ->setStatus($this->statusRepository->findOneBy(['deleted' => false,'reference' => FixedValuesConstants::STATUS_DEMANDE_SOUMISE]))
                ->setReference("000010010");
           $entityManager->persist($demande);
           $entityManager->flush();
           return  $this->redirectToRoute('app_demande_index');
        }

        return $this->render('demande/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_demande_show', methods: ['GET'])]
    public function show(Demande $demande): Response
    {
        return $this->render('demande/show.html.twig', [
            'demande' => $demande,
        ]);
    }

    #[Route('/validated/{id}', name: 'app_demande_validated', methods: ['GET', 'POST'])]
    public function validated(Demande $demande): Response{
        if($demande->getDeleted() === false){
            $demande->setStatus($this->statusRepository->findOneBy(['deleted' => false, 'reference'=> FixedValuesConstants::STATUS_DEMANDE_VALIDEE]));
        }
        return $this->redirectToroute('demande_en_attente_traitement');
    }
    #[Route('/{id}/edit', name: 'app_demande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Demande $demande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DemandeForm::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_demande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('demande/edit.html.twig', [
            'demande' => $demande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_demande_delete', methods: ['POST'])]
    public function delete(Request $request, Demande $demande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demande->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($demande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_demande_index', [], Response::HTTP_SEE_OTHER);
    }
}
