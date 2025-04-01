<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Entity\SessionQuizz;
use App\Entity\User;
use App\Entity\Quizz;
use App\Entity\UserResponse;
use App\Enum\Status;
use App\Enum\Mode;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;

class SessionQuizzTest extends TestCase
{
    public function testSessionQuizzCreation()
    {
        $sessionQuizz = new SessionQuizz();
        $this->assertInstanceOf(SessionQuizz::class, $sessionQuizz);
    }
    
    public function testStatusGetterSetter()
    {
        $sessionQuizz = new SessionQuizz();
        $status = Status::PENDING->value;
        
        $sessionQuizz->setStatus($status);
        $this->assertEquals($status, $sessionQuizz->getStatus());
    }
    
    public function testModeGetterSetter()
    {
        $sessionQuizz = new SessionQuizz();
        $mode = Mode::MULTIPLAYER->value;
        
        $sessionQuizz->setMode($mode);
        $this->assertEquals($mode, $sessionQuizz->getMode());
    }
    
    public function testStartDateGetterSetter()
    {
        $sessionQuizz = new SessionQuizz();
        $startDate = new DateTimeImmutable();
        
        $sessionQuizz->setStartDate($startDate);
        $this->assertEquals($startDate, $sessionQuizz->getStartDate());
    }
    
    public function testEndDateGetterSetter()
    {
        $sessionQuizz = new SessionQuizz();
        $endDate = new DateTimeImmutable();
        
        $sessionQuizz->setEndDate($endDate);
        $this->assertEquals($endDate, $sessionQuizz->getEndDate());
    }
    
    public function testPresenterGetterSetter()
    {
        $sessionQuizz = new SessionQuizz();
        $presenter = new User();
        
        $sessionQuizz->setPresenter($presenter);
        $this->assertSame($presenter, $sessionQuizz->getPresenter());
    }
    
    public function testQuizzGetterSetter()
    {
        $sessionQuizz = new SessionQuizz();
        $quizz = new Quizz();
        
        $sessionQuizz->setQuizz($quizz);
        $this->assertSame($quizz, $sessionQuizz->getQuizz());
    }
    
    public function testParticipantsCollection()
    {
        $sessionQuizz = new SessionQuizz();
        
        $this->assertInstanceOf(Collection::class, $sessionQuizz->getParticipants());
        $this->assertEquals(0, $sessionQuizz->getParticipants()->count());
    }
    
    public function testAddRemoveParticipant()
    {
        $sessionQuizz = new SessionQuizz();
        $participant = new User();
        
        $sessionQuizz->addParticipant($participant);
        $this->assertTrue($sessionQuizz->getParticipants()->contains($participant));
        
        $sessionQuizz->removeParticipant($participant);
        $this->assertFalse($sessionQuizz->getParticipants()->contains($participant));
    }
    
    public function testUserResponsesCollection()
    {
        $sessionQuizz = new SessionQuizz();
        
        $this->assertInstanceOf(Collection::class, $sessionQuizz->getUserResponses());
        $this->assertEquals(0, $sessionQuizz->getUserResponses()->count());
    }
    
    public function testAddRemoveUserResponse()
    {
        $sessionQuizz = new SessionQuizz();
        $userResponse = new UserResponse();
        
        $sessionQuizz->addUserResponse($userResponse);
        $this->assertTrue($sessionQuizz->getUserResponses()->contains($userResponse));
        $this->assertSame($sessionQuizz, $userResponse->getSessionQuizz());
        
        $sessionQuizz->removeUserResponse($userResponse);
        $this->assertFalse($sessionQuizz->getUserResponses()->contains($userResponse));
    }
}
