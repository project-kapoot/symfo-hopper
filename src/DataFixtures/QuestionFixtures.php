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
    public static int $questionCount = 0;

    public function load(
        ObjectManager $manager,
    ): void {
        $faker = Factory::create('fr_FR');
        // create 5 to 20 questions per quizz
        for ($i = 0; $i < 50; $i++) {
            $quizz = $this->getReference('quizz_' . $i, Quizz::class);
            $rndQty = $faker->numberBetween(5, 20);
            for ($j = 0; $j < $rndQty; $j++) {
                $question = new Question();
                $questionContent = $faker->words(40, true) . "?";
                $question->setContent($questionContent)
                    ->setExplanation($faker->text(100))
                    ->setTimeMax(\DateInterval::createFromDateString('30 seconds'))
                    ->setScoreMin(0)
                    ->setScoreMax((int)(floor(500 / $rndQty)))
                    ->setQuizz($quizz);

                $manager->persist($question);
                $this->addReference('question_' . self::$questionCount, $question);
                self::$questionCount++;
            }
        }

        $manager->flush();
    }

    public static function getQuestionCount(): int
    {
        return self::$questionCount;
    }

    public function getDependencies(): array
    {
        return [
            QuizzFixtures::class,
        ];
    }
}
