<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Entity\Answer;
use App\Entity\Question;

class AnswerTest extends TestCase
{
    public function testAnswerCreation()
    {
        $answer = new Answer();
        $this->assertInstanceOf(Answer::class, $answer);
    }
    
    public function testContentGetterSetter()
    {
        $answer = new Answer();
        $content = "Paris";
        
        $answer->setContent($content);
        $this->assertEquals($content, $answer->getContent());
    }
    
    public function testIsCorrectGetterSetter()
    {
        $answer = new Answer();
        
        $answer->setIsCorrect(true);
        $this->assertTrue($answer->isCorrect());
    }
    
    public function testQuestionGetterSetter()
    {
        $answer = new Answer();
        $question = new Question();
        
        $answer->setQuestion($question);
        $this->assertSame($question, $answer->getQuestion());
    }
}