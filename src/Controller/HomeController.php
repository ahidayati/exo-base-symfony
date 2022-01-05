<?php

namespace App\Controller;

use App\Repository\AccountRepository;
use App\Repository\CommentRepository;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(GameRepository $gameRepository, CommentRepository $commentRepository, AccountRepository $accountRepository): Response
    {

        dump($commentRepository->findAllCommentsByDate(5));
        return $this->render('home/index.html.twig', [
            'displayGamesByName' => $gameRepository->findGamesByName(10),
            'displayGamesByReleaseDate' => $gameRepository->findGamesByReleaseDate(4),
            'displayLatestComments' => $commentRepository->findAllCommentsByDate(5),

        ]);

    }

}