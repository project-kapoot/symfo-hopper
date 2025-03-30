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
        // create 50 session quizz
        for ($i = 0; $i < 50; $i++) {
            $sessionQuizz = new SessionQuizz();
            $rndIndex = $faker->randomDigit(0, 9);

            $quizz = $this->getReference('quizz_' . $i, Quizz::class);
            $presenter = $this->getReference('editor_' . $rndIndex, User::class);

            $startDate = new \DateTimeImmutable($faker->dateTimeBetween('-1 month', '-2 weeks')->format('Y-m-d H:i:s'));

            $sessionQuizz->setStatus('finished') // ['waiting', 'in_progress', 'finished']
                ->setStartDate($startDate)
                ->setEndDate($startDate->modify('+1 hour'))
                ->setQuizz($quizz)
                ->setPresenter($presenter);

            $manager->persist($sessionQuizz);

            $this->addReference('sessionQuizz_' . $i, $sessionQuizz);

            if($i < 30) {
                $sessionQuizz->setMode('multi_players');

                $this->addReference('sessionQuizzMultiPlayers_' . $i, $sessionQuizz); // session quizz multi 0-29
            } else {
                $sessionQuizz->setMode('solo');

                $this->addReference('sessionQuizzSolo_' . ($i - 30), $sessionQuizz); // session quizz solo 0-19
            }
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
