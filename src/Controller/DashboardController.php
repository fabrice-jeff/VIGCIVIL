<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    #[Route('/', name: 'app_dashboard')]
    public function index(): Response
    {
        if($this->isGranted('ROLE_CONSULAT')){
            return $this->render('dashboard/dashboard_consulat.twig', [
            ]);
        }
        else if($this->isGranted('ROLE_AGENT')){
            return $this->render('dashboard/dashboard_agent.html.twig', [
            ]);
        }
        return $this->render('dashboard/dashboard_admin.html.twig', [
            'users' => $this->userRepository->findAll(),
        ]);
    }
}
