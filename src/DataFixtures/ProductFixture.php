<?php
// src/DataFixtures/ProductFixture.php
namespace App\DataFixtures;

use App\Entity\Gamme;
use App\Entity\Product;
use App\Entity\Pictures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Driver\IBMDB2\Exception\Factory;

class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $gammes = $manager->getRepository(Gamme::class)->findAll();
        $pictures = $manager->getRepository(Pictures::class)->findAll();

        for ($i = 0; $i < 15; $i++) {
            $product = new Product();
            $product->setNameProduct($faker->word);
            $product->setPrice($faker->numberBetween(10, 1000));
            $product->setGamme($faker->randomElement($gammes));
            $product->addPicture($faker->randomElement($pictures));

            $manager->persist($product);
        }

        $manager->flush();
    }
}
