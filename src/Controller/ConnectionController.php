<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConnectionController extends AbstractController
{
    public function __construct(private UserRepository $userRepository) {
    }
    #[Route('/connection', name: 'app_trombinoscope')]
    public function index(): Response
    {
        $users = $this->userRepository->findAll();
        return $this->render('trombinoscope/index.html.twig', [
            'users' => $users,
        ]);
    }
}
