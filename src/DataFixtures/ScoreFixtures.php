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
        // create 50 scores
        for ($i = 0; $i < 50; $i++) {
            $score = new Score();

            $player = $this->getReference('user_' . $i, User::class);
            $sessionQuizz = $this->getReference('sessionQuizz_' . $i, SessionQuizz::class);

            $score->setFinalScore($faker->numberBetween(0, 500))
                ->setRank($faker->numberBetween(1, 10))
                ->setSessionQuizz($sessionQuizz)
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
