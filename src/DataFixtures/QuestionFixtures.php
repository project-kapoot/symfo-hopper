<?php

namespace App\DataFixtures;

use App\Entity\Question;
use App\Entity\Quizz;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuestionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(
        ObjectManager $manager,
    ): void {
        $faker = Factory::create('fr_FR');
        // create 50 questions
        for ($i = 0; $i < 50; $i++) {
            $question = new Question();

            $quizz = $this->getReference('quizz_' . $i, Quizz::class);

            $questionContent = $faker->words(40, true) . "?";

            $question->setContent($questionContent)
                ->setExplanation($faker->text(100))
                ->setTimeMax(\DateInterval::createFromDateString('30 seconds'))
                ->setScoreMin(0)
                ->setScoreMax(200)
                ->setQuizz($quizz);

            $manager->persist($question);

            $this->addReference('question_' . $i, $question);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            QuizzFixtures::class,
        ];
    }
}
