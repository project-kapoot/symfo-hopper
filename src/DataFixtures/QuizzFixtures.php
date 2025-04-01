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

            $rndIndex = $faker->randomDigit(0, 9);
            $author = $this->getReference('editor_' . $rndIndex, User::class);

            $quizz->setName($faker->words(3, true))
                ->setDescription($faker->text(200))
                ->setLogo($faker->word() . '.png')
                ->setAuthor($author);

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
