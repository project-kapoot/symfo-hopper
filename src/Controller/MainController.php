<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('nav/index.html.twig');
    }

    #[Route('/dashboard', name: 'app_dashboard')]
    public function dashboard(): Response
    {
        return $this->render('dashboard/dashboard.html.twig');
    }

    #[Route('/create_quiz', name: 'app_create_quiz')]
    public function createQuiz(): Response
    {
        return $this->render('create_quiz/create_quiz.html.twig');
    }

    #[Route('/waiting_room', name: 'app_waiting_room')]
    public function waittingRoom(): Response
    {
        return $this->render('waiting_room/waiting_room.html.twig');
    }

    #[Route('/quiz_in_progress', name: 'app_quiz_in_progress')]
    public function quizInProgress(): Response
    {
        return $this->render('quiz_in_progress/quiz_in_progress.html.twig');
    }

    #[Route('/game_result', name: 'app_game_result')]
    public function gameResult(): Response
    {
        return $this->render('game_result/game_result.html.twig');
    }
}
