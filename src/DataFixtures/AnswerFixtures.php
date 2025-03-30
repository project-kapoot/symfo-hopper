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
        // create 50 answers
        for ($i = 0; $i < 50; $i++) {
            $answer = new Answer();

            $question = $this->getReference('question_' . $i, Question::class);

            $answer->setContent($faker->words(20, true))
                ->setIsCorrect($faker->randomElement([true, false]))
                ->setQuestion($question);

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
