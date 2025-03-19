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
        return $this->render('pages/index.html.twig');
    }

    #[Route('/dashboard', name: 'app_dashboard')]
    public function dashboard(): Response
    {
        return $this->render('pages/dashboard.html.twig');
    }

    #[Route('/create_quiz', name: 'app_create_quiz')]
    public function createQuiz(): Response
    {
        return $this->render('pages/create_quiz.html.twig');
    }

    #[Route('/waiting_room', name: 'app_waiting_room')]
    public function waitingRoom(): Response
    {
        return $this->render('pages/waiting_room.html.twig');
    }

    #[Route('/quiz_in_progress', name: 'app_quiz_in_progress')]
    public function quizInProgress(): Response
    {
        return $this->render('pages/quiz_in_progress.html.twig');
    }

    #[Route('/game_result', name: 'app_game_result')]
    public function gameResult(): Response
    {
        return $this->render('pages/game_result.html.twig');
    }

    #[Route('/hall_of_fame', name: 'app_hall_of_fame')]
    public function hallOfFame(): Response
    {
        $players = [
            ['name' => 'Éléonore', 'score' => 1500],
            ['name' => 'Manuel', 'score' => 1470],
            ['name' => 'Anaëlle', 'score' => 1410],
            ['name' => 'Céleste', 'score' => 1400],
        ];

        return $this->render('pages/hall_of_fame.html.twig', ['players' => $players] );
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('pages/about.html.twig');
    }


}
