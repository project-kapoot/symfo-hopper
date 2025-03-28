<?php

namespace App\DataFixtures;

use App\Entity\Quizz;
use App\Entity\User;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuizzFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(
        ObjectManager $manager,
    ): void {
        $faker = Factory::create('fr_FR');
        // create 50 quizz
        for ($i = 0; $i < 50; $i++) {
            $quizz = new Quizz();

            $quizz->setName($faker->words(3, true))
                ->setDescription($faker->text(200))
                ->setLogo($faker->word() . '.png');

            $author = $this->getReference('user_' . $i, User::class);
            $quizz->setAuthor($author);

            $manager->persist($quizz);
            $this->addReference('quizz_' . $i, $quizz);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
