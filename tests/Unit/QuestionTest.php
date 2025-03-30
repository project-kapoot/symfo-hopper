<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Entity\Question;
use DateInterval;

class QuestionTest extends TestCase
{
    public function testQuestionCreation()
    {
        $question = new Question();
        $this->assertInstanceOf(Question::class, $question);
    }
    
    public function testExplanationGetterSetter()
    {
        $question = new Question();
        $explanation = "Paris est la capitale de la France.";
        
        $question->setExplanation($explanation);
        $this->assertEquals($explanation, $question->getExplanation());
    }
    
    public function testScoreMinGetterSetter()
    {
        $question = new Question();
        $scoreMin = 5;
        
        $question->setScoreMin($scoreMin);
        $this->assertEquals($scoreMin, $question->getScoreMin());
    }
    
    public function testScoreMaxGetterSetter()
    {
        $question = new Question();
        $scoreMax = 10;
        
        $question->setScoreMax($scoreMax);
        $this->assertEquals($scoreMax, $question->getScoreMax());
    }
    
    public function testTimeMaxGetterSetter()
    {
        $question = new Question();
        $timeMax = new DateInterval('PT30S'); // 30 secondes
        
        $question->setTimeMax($timeMax);
        $this->assertEquals($timeMax, $question->getTimeMax());
    }
}
