<?php

namespace App\DataFixtures;

use App\Entity\Quizz;
use App\Entity\SessionQuizz;
use App\Entity\User;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SessionQuizzFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(
        ObjectManager $manager,
    ): void {
        $faker = Factory::create('fr_FR');
        // create 50 SessionQuizz
        for ($i = 0; $i < 50; $i++) {
            $sessionQuizz = new SessionQuizz();
            $sessionQuizz->setStatus($faker->randomElement(['waiting', 'in_progress', 'finished']))
                ->setMode($faker->randomElement(['solo', 'multi_players']))
                ->setStartDate(new \DateTimeImmutable($faker->dateTimeBetween('-1 month', '-2 weeks')->format('Y-m-d H:i:s')));

            $startDate = $sessionQuizz->getStartDate();

            $sessionQuizz->setEndDate($startDate->modify('+1 hour'));

            $quizz = $this->getReference('quizz_' . $i, Quizz::class);
            $sessionQuizz->setQuizz($quizz);

            $presenter = $this->getReference('user_' . $i, User::class);
            $sessionQuizz->setPresenter($presenter);

            $manager->persist($sessionQuizz);

            $this->addReference('sessionQuizz_' . $i, $sessionQuizz);
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
