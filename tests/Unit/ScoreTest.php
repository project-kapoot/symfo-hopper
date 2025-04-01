<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Entity\User;
use App\Entity\Score;
use App\Entity\SessionQuizz;

class ScoreTest extends TestCase
{
    private function createScore(): Score
    {
        $score = new Score();

        $player = new User();
        $sessionQuizz = new SessionQuizz();

        $score->setFinalScore(100)
            ->setRank(1)
            ->setPlayer($player)
            ->setSessionQuizz($sessionQuizz);

        return $score;
    }

    public function testIsTrue()
    {
        $score = $this->createScore();

        $this->assertSame(100, $score->getFinalScore());
        $this->assertSame(1, $score->getRank());
    }

    public function testIsFalse()
    {
        $score = $this->createScore();

        $this->assertNotSame(50, $score->getFinalScore());
        $this->assertNotSame(2, $score->getRank());
    }

    public function testIsNull()
    {
        $score = new Score();

        $this->assertNull($score->getId());
        $this->assertNull($score->getPlayer());
        $this->assertNull($score->getSessionQuizz());
    }

    public function testGetSetPlayer()
    {
        $score = $this->createScore();
        $player = new User();
        
        $score->setPlayer($player);

        $this->assertSame($player, $score->getPlayer());
    }

    public function testGetSetSessionQuizz()
    {
        $score = $this->createScore();
        $sessionQuizz = new SessionQuizz();

        $score->setSessionQuizz($sessionQuizz);

        $this->assertSame($sessionQuizz, $score->getSessionQuizz());
    }
}
