<?php

namespace App\Controller;

use App\Repository\DemandeRepository;
use App\Repository\StatusRepository;
use App\Repository\UserRepository;
use App\Utils\Constants\FixedValuesConstants;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private DemandeRepository $demandeRepository,
        private StatusRepository $statusRepository,
    )
    {
    }

    #[Route('/', name: 'app_dashboard')]
    public function index(): Response
    {
        $statusEnAttente = $this->statusRepository->findOneBy(['deleted' => false, 'reference'=> FixedValuesConstants::STATUS_DEMANDE_SOUMISE]);
        $statusEnCours = $this->statusRepository->findOneBy(['deleted' => false, 'reference' => FixedValuesConstants::STATUS_DEMANDE_EN_COURS_TRAITEMENT]);
        $demandesEnAttente = $this->demandeRepository->findBy(['deleted' => false, 'status' => $statusEnAttente]);
        $demandesTraitees = $this->demandeRepository->findDemandeTraitees( $statusEnAttente, $statusEnCours);
        if($this->isGranted('ROLE_CONSULAT') || $this->isGranted('ROLE_AGENT')){
            return $this->render('dashboard/dashboard_agent.twig', [
                'demandesEnAttente' => $demandesEnAttente,
                'demandesTraitees' => $demandesTraitees,
            ]);
        }

        return $this->render('dashboard/dashboard_admin.html.twig', [
            'users' => $this->userRepository->findAll(),
        ]);
    }
}
