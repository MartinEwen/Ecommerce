<?php
// ProductFixture.php
namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Gamme;
use App\Entity\Product;
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
        $pictures = $manager->getRepository(Pictures::class)->findAll();

        for ($i = 0; $i < 100; $i++) {
            $product = new Products(); // Correction du nom de la classe
            $product->setNameProducts($faker->word);
            $product->setPrice($faker->numberBetween(10, 1000));
            $product->setGamme($faker->randomElement($gammes));

            // Générer un nombre aléatoire entre 2 et 5 pour le nombre d'images à associer
            $numImages = $faker->numberBetween(2, 5);
    
            // Sélectionner aléatoirement entre 2 et 5 images différentes
            $selectedImages = $faker->randomElements($pictures, $numImages);
    
            foreach ($selectedImages as $image) {
                $product->addPicture($image);
            }
    
            $manager->persist($product);
        }

        $manager->flush();
    }
}
