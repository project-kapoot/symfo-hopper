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
                ->setGlobalScore($faker->numberBetween(0, 3000))
                ->setPassword(
                    $this->userPasswordHasher->hashPassword(
                        $user,
                        'password'
                    )
                );
            $manager->persist($user);

            $this->addReference('user_' . $i, $user);

            if ($i < 30) {
                $user->setRoles(['ROLE_PLAYER']);
                $this->addReference('player_' . $i, $user); // player 0-29
            } elseif ($i < 40) {
                $user->setRoles(['ROLE_EDITOR']);
                $this->addReference('editor_' . ($i - 30), $user); // editor 0-9
            } else {
                $user->setRoles(['ROLE_ADMIN']);
                $this->addReference('admin_' . ($i - 40), $user); // admin 0-9
            }
        }

        $manager->flush();
    }
}
