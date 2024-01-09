<?php
// src/DataFixtures/GammeFixture.php
namespace App\DataFixtures;

use App\Entity\Gamme;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Driver\IBMDB2\Exception\Factory;

class GammeFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR'); 

        for ($i = 0; $i < 5; $i++) {
            $gamme = new Gamme();
            $gamme->setNameGamme($faker->word);

            $manager->persist($gamme);
        }

        $manager->flush();
    }
}
