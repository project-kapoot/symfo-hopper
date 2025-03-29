<?php

namespace App\DataFixtures;

use App\Entity\Question;
use App\Entity\Quizz;
use App\Entity\User;
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

            $questionContent = $faker->words(40, true) . "?";
            $question->setContent($questionContent)
                ->setExplanation($faker->text(200))
                ->setTimeMax(\DateInterval::createFromDateString('30 seconds'))
                ->setScoreMin(0)
                ->setScoreMax(100);
                

            $quizz = $this->getReference('quizz_' . $i, Quizz::class);
            $question->setQuizz($quizz);

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
