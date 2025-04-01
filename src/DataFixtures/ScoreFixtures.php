<?php

namespace App\DataFixtures;

use App\Entity\Score;
use App\Entity\SessionQuizz;
use App\Entity\User;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ScoreFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(
        ObjectManager $manager,
    ): void {
        $faker = Factory::create('fr_FR');

        // 30 session quizz multi players > create 2-30 scores
        for ($i = 0; $i < 30; $i++) {
            $sessionQuizz = $this->getReference('sessionQuizzMultiPlayers_' . $i, SessionQuizz::class);

            $rndQty = $faker->numberBetween(2, 30);

            for ($j = 0; $j < $rndQty; $j++) {
                $score = new Score();
                $indexPlayer = $faker->numberBetween(0, 29);
                $player = $this->getReference('player_' . $indexPlayer, User::class);
                $score->setSessionQuizz($sessionQuizz)
                    ->setFinalScore(500 - $j * 25)
                    ->setRank($j + 1)
                    ->setPlayer($player);

                $manager->persist($score);
            }
        }

        // 20 session quizz solo > create only 1 score
        for ($i = 0; $i < 20; $i++) {
            $sessionQuizz = $this->getReference('sessionQuizzSolo_' . $i, SessionQuizz::class);

            $score = new Score();
            $indexPlayer = $faker->numberBetween(0, 29);
            $player = $this->getReference('player_' . $indexPlayer, User::class);
            $score->setSessionQuizz($sessionQuizz)
                ->setFinalScore($faker->numberBetween(0, 500))
                ->setRank(1)
                ->setPlayer($player);

            $manager->persist($score);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SessionQuizzFixtures::class,
            UserFixtures::class,
        ];
    }
}
