<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\SessionQuizz;
use App\Entity\User;
use App\Entity\UserResponse;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserResponseFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(
        ObjectManager $manager,
    ): void {
        $faker = Factory::create('fr_FR');
        // create 50 user responses
        for ($i = 0; $i < 50; $i++) {
            $userResponse = new UserResponse();
            
            $player = $this->getReference('user_' . $i, User::class);
            $sessionQuizz = $this->getReference('sessionQuizz_' . $i, SessionQuizz::class);
            $question = $this->getReference('question_' . $i, Question::class);
            $answer = $this->getReference('answer_' . $i, Answer::class);

            $userResponse->setResponseScore($faker->numberBetween(0, 100))
                ->setResponseTime($faker->numberBetween(0, 3000))
                ->setPlayer($player)
                ->setSessionQuizz($sessionQuizz)
                ->setQuestion($question)
                ->addAnswer($answer);

            $manager->persist($userResponse);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            SessionQuizzFixtures::class,
            QuestionFixtures::class,
            AnswerFixtures::class,
        ];
    }
}
