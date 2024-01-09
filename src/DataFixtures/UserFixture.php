<?php
// src/DataFixtures/UserFixture.php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $user = new User();
            $user->setName($faker->lastName);
            $user->setFirstName($faker->firstName);
            $user->setEmail($faker->email); // Utilisation de Faker pour générer des e-mails uniques et non vides
            $user->setPassword($faker->password);
            $user->setAdress($faker->address);
            $user->setPseudo($faker->userName);
            $user->setCity($faker->city);
            $user->setRoles(['ROLE_USER']); // Vous pouvez ajuster les rôles au besoin

            $manager->persist($user);
        }

        $manager->flush();
    }
}
