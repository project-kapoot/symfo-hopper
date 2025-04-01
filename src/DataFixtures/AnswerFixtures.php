<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
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

        $questionCount = QuestionFixtures::getQuestionCount();
        // create 4 answers per question
        for ($i = 0; $i < $questionCount; $i++) {
            $question = $this->getReference('question_' . $i, Question::class);

            for ($j = 0; $j < 4; $j++) {
                $answer = new Answer();

                $answer->setContent($faker->words(20, true))
                    ->setIsCorrect($faker->randomElement([true, false]))
                    ->setQuestion($question);

                $manager->persist($answer);

                $this->addReference('answer_' . ($i * 4 + $j), $answer);
            }
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
