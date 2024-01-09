<?php
// src/DataFixtures/PicturesFixture.php
namespace App\DataFixtures;

use App\Entity\Pictures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;

class PicturesFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 700; $i++) {
            $picture = new Pictures();
            $picture->setNamePicture($faker->imageUrl());

            $manager->persist($picture);
        }

        $manager->flush();
    }
}
