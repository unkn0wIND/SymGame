<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(GameRepository $gameRepository): Response
    {
        return $this->render('pages/home.html.twig', [
            'games' => $gameRepository->findAll()
        ]);
    }
}
