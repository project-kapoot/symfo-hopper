<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1.title', 'Kapoot');
        $this->assertSelectorTextContains('h2.subtitle', 'Apprenez tout en vous amusant avec nos quiz interactifs !');
        $this->assertSelectorTextContains('p', 'Découvrez les joueurs les plus performants de tous les temps !');

    }

    public function testDashboard(): void
    {
        $client = static::createClient();
        $client->request('GET', '/dashboard');

        $this->assertResponseIsSuccessful();
    }

    public function testCreateQuiz(): void
    {
        $client = static::createClient();
        $client->request('GET', '/create_quiz');

        $this->assertResponseIsSuccessful();
    }

    public function testWaitingRoom(): void
    {
        $client = static::createClient();
        $client->request('GET', '/waiting_room');

        $this->assertResponseIsSuccessful();
    }

    public function testQuizInProgress(): void
    {
        $client = static::createClient();
        $client->request('GET', '/quiz_in_progress');

        $this->assertResponseIsSuccessful();
    }

    public function testGameResult(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game_result');

        $this->assertResponseIsSuccessful();
    }

    public function testHallOfFame(): void
    {
        $client = static::createClient();
        $client->request('GET', '/hall_of_fame');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Éléonore'); // Vérifie que le nom d'un joueur est bien affiché
        $this->assertSelectorTextContains('body', '1500'); // Vérifie que le score est bien affiché
    }

    public function testAbout(): void
    {
        $client = static::createClient();
        $client->request('GET', '/about');

        $this->assertResponseIsSuccessful();
    }
}