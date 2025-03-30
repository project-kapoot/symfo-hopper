<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Entity\UserResponse;
use App\Entity\User;
use App\Entity\Question;
use App\Entity\SessionQuizz;
use DateInterval;

class UserResponseTest extends TestCase
{
    public function testUserResponseCreation()
    {
        $userResponse = new UserResponse();
        $this->assertInstanceOf(UserResponse::class, $userResponse);
    }
    
    public function testScoreGetterSetter()
    {
        $userResponse = new UserResponse();
        $score = 10;
        
        $userResponse->setScore($score);
        $this->assertEquals($score, $userResponse->getScore());
    }
    
    public function testResponseTimeGetterSetter()
    {
        $userResponse = new UserResponse();
        $responseTime = new DateInterval('PT10S'); // 10 secondes
        
        $userResponse->setResponseTime($responseTime);
        $this->assertEquals($responseTime, $userResponse->getResponseTime());
    }
    
    public function testPlayerGetterSetter()
    {
        $userResponse = new UserResponse();
        $player = new User();
        
        $userResponse->setPlayer($player);
        $this->assertSame($player, $userResponse->getPlayer());
    }
    
    public function testSessionQuizzGetterSetter()
    {
        $userResponse = new UserResponse();
        $sessionQuizz = new SessionQuizz();
        
        $userResponse->setSessionQuizz($sessionQuizz);
        $this->assertSame($sessionQuizz, $userResponse->getSessionQuizz());
    }
    
    public function testQuestionGetterSetter()
    {
        $userResponse = new UserResponse();
        $question = new Question();
        
        $userResponse->setQuestion($question);
        $this->assertSame($question, $userResponse->getQuestion());
    }
}