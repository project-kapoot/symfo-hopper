<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Quizz;
use App\Entity\SessionQuizz;
use App\Entity\User;
use App\Entity\UserResponse;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AnswerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(
        ObjectManager $manager,
    ): void {
        $faker = Factory::create('fr_FR');
        // create 50 questions
        for ($i = 0; $i < 50; $i++) {
            $answer = new Answer();

            $answer->setContent($faker->words(30, true))
                ->setIsCorrect($faker->randomElement([true, false]));   

            $question = $this->getReference('question_' . $i, Question::class);

            $answer->setQuestion($question);

            $manager->persist($answer);

            $this->addReference('answer_' . $i, $answer);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            QuestionFixtures::class,
        ];
    }
}
