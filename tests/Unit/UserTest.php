<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Entity\User;
use App\Entity\Quizz;
use App\Entity\UserResponse;
use Doctrine\Common\Collections\Collection;

class UserTest extends TestCase
{
    public function testUserCreation()
    {
        $user = new User();
        $this->assertInstanceOf(User::class, $user);
    }
    
    public function testUsernameGetterSetter()
    {
        $user = new User();
        $username = "johndoe";
        
        $user->setUsername($username);
        $this->assertEquals($username, $user->getUsername());
    }
    
    public function testEmailGetterSetter()
    {
        $user = new User();
        $email = "john@example.com";
        
        $user->setEmail($email);
        $this->assertEquals($email, $user->getEmail());
    }
    
    public function testPasswordGetterSetter()
    {
        $user = new User();
        $password = "hashedpassword";
        
        $user->setPassword($password);
        $this->assertEquals($password, $user->getPassword());
    }
    
    public function testRolesGetterSetter()
    {
        $user = new User();
        $roles = ["ROLE_ADMIN"];
        
        $user->setRoles($roles);
        // getRoles() ajoute toujours ROLE_USER
        $this->assertEquals(["ROLE_ADMIN", "ROLE_USER"], $user->getRoles());
    }
    
    public function testDefaultRoles()
    {
        $user = new User();
        // Par défaut, un utilisateur a au moins ROLE_USER
        $this->assertEquals(["ROLE_USER"], $user->getRoles());
    }
    
    public function testUserIdentifier()
    {
        $user = new User();
        $email = "john@example.com";
        
        $user->setEmail($email);
        $this->assertEquals($email, $user->getUserIdentifier());
    }
    public function testGlobalScoreGetterSetter()
    {
        $user = new User();
        $globalScore = 1000;
        
        $user->setGlobalScore($globalScore);
        $this->assertEquals($globalScore, $user->getGlobalScore());
    }

    public function testQuizzesCollection()
    {
        $user = new User();
        
        $this->assertInstanceOf(Collection::class, $user->getQuizzes());
        $this->assertEquals(0, $user->getQuizzes()->count());
    }
    
    public function testAddRemoveQuiz()
    {
        $user = new User();
        $quizz = new Quizz();
        
        $user->addQuiz($quizz);
        $this->assertTrue($user->getQuizzes()->contains($quizz));
        $this->assertSame($user, $quizz->getAuthor());
        
        $user->removeQuiz($quizz);
        $this->assertFalse($user->getQuizzes()->contains($quizz));
    }
    
    public function testUserResponsesCollection()
    {
        $user = new User();
        
        $this->assertInstanceOf(Collection::class, $user->getUserResponses());
        $this->assertEquals(0, $user->getUserResponses()->count());
    }
    
    public function testAddRemoveUserResponse()
    {
        $user = new User();
        $userResponse = new UserResponse();
        
        $user->addUserResponse($userResponse);
        $this->assertTrue($user->getUserResponses()->contains($userResponse));
        $this->assertSame($user, $userResponse->getPlayer());
        
        $user->removeUserResponse($userResponse);
        $this->assertFalse($user->getUserResponses()->contains($userResponse));
    }
    
    public function testEraseCredentials()
    {
        $user = new User();
        // Cette méthode ne fait rien dans notre implémentation,
        // mais nous vérifions qu'elle peut être appelée sans erreur
        $user->eraseCredentials();
        $this->assertTrue(true);
    }
}
