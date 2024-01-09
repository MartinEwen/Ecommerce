<?php
// src/DataFixtures/UserFixture.php
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Driver\IBMDB2\Exception\Factory;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setName($faker->lastName);
            $user->setFirstName($faker->firstName);
            $user->setMail($faker->email);
            $user->setPassword($faker->password);
            $user->setAddress($faker->address);
            $user->setPseudo($faker->userName);
            $user->setCity($faker->city);
            $user->setRoles(['ROLE_USER']); // You can modify roles as needed

            $manager->persist($user);
        }

        $manager->flush();
    }
}
