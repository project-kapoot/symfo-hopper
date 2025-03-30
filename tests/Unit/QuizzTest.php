<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Entity\Quizz;
use App\Entity\User;
use App\Entity\Question;
use Doctrine\Common\Collections\Collection;

class QuizzTest extends TestCase
{
    public function testQuizzCreation()
    {
        $quizz = new Quizz();
        $this->assertInstanceOf(Quizz::class, $quizz);
    }
    
    public function testNameGetterSetter()
    {
        $quizz = new Quizz();
        $name = "Quiz de géographie";
        
        $quizz->setName($name);
        $this->assertEquals($name, $quizz->getName());
    }
    
    public function testDescriptionGetterSetter()
    {
        $quizz = new Quizz();
        $description = "Un quiz pour tester vos connaissances en géographie";
        
        $quizz->setDescription($description);
        $this->assertEquals($description, $quizz->getDescription());
    }
    
    public function testLogoGetterSetter()
    {
        $quizz = new Quizz();
        $logo = "logo.png";
        
        $quizz->setLogo($logo);
        $this->assertEquals($logo, $quizz->getLogo());
    }
    
    public function testAuthorGetterSetter()
    {
        $quizz = new Quizz();
        $author = new User();
        
        $quizz->setAuthor($author);
        $this->assertSame($author, $quizz->getAuthor());
    }
    
    public function testQuestionsCollection()
    {
        $quizz = new Quizz();
        
        // Vérifier que getQuestions() retourne une Collection
        $this->assertInstanceOf(Collection::class, $quizz->getQuestions());
        
        // Vérifier que la collection est initialement vide
        $this->assertEquals(0, $quizz->getQuestions()->count());
    }
    
    public function testAddQuestion()
    {
        $quizz = new Quizz();
        $question = new Question();
        
        $quizz->addQuestion($question);
        
        $this->assertTrue($quizz->getQuestions()->contains($question));
        $this->assertSame($quizz, $question->getQuizz());
    }
    
    public function testRemoveQuestion()
    {
        $quizz = new Quizz();
        $question = new Question();
        
        $quizz->addQuestion($question);
        $quizz->removeQuestion($question);
        
        $this->assertFalse($quizz->getQuestions()->contains($question));
    }
}
