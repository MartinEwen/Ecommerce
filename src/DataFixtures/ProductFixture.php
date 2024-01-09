<?php
// ProductFixture.php
namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Gamme;
use App\Entity\Pictures;
use App\Entity\Products;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $gammes = $manager->getRepository(Gamme::class)->findAll();

        for ($i = 0; $i < 100; $i++) {
            $product = new Products();
            $product->setNameProducts($faker->word);
            $product->setPrice($faker->numberBetween(10, 1000));
            $product->setGamme($faker->randomElement($gammes));

            $manager->persist($product);

            $numImages = $faker->numberBetween(2, 5);

            // Créer et associer des images à ce produit
            for ($j = 0; $j < $numImages; $j++) {
                $picture = new Pictures();
                $picture->setNamePicture($faker->word);

                // Associer l'image au produit en cours de traitement
                $picture->setProducts($product);
                $manager->persist($picture);
            }
        }

        $manager->flush();
    }
}
