<?php

namespace App\DataFixtures;

use App\Entity\User;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
    ) {}

    public function load(
        ObjectManager $manager,
    ): void {
        $faker = Factory::create('fr_FR');
        // create 50 users
        for ($i = 0; $i < 50; $i++) {
            $user = new User();
            $user->setUsername($faker->userName())
                ->setEmail($faker->email())
                ->setRoles($faker->randomElements(['ROLE_USER', 'ROLE_EDITOR', 'ROLE_ADMIN'], 1))
                ->setPassword(
                    $this->userPasswordHasher->hashPassword(
                        $user,
                        'password'
                    )
                );
            $this->addReference('user_' . $i, $user);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
