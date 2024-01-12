<?php
// ProductFixture.php
namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Gamme;
use App\Entity\Pictures;
use App\Entity\Products;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductFixture extends Fixture
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();
        $gammes = $manager->getRepository(Gamme::class)->findAll();

        $colors = ['yellow', 'green', 'blue', 'red'];
        $sizes = ['small', 'medium', 'large', 'Extra Large'];
        $raceCanard = ['Canard de Barbarie','Canard mandarin','Canard colvert','Canard Pékinois','Canard de Rouen','Canard Cayuga','Canard d\'Aylesbury','Canard de l\'Orégon','Canard de Saxe', 'Canard Coureur Indien','Canard de Laysan','Canard Mignon','Canard Whistling','Canard Pintade','Canard Fuligule','Canard Mignon','Canard Siffleur','Canard Sarcelle','Canard Kaki Campbell','Canard Long Island'];
        $nameCanard = ['Donald','Daisy','Daffy','Howard','Quacker','Webby','Scrooge','Mallory','Ferdinand','Gladstone','Launchpad','Beakley','Darkwing','Huey','Dewey', 'Louie','Magica','Gizmoduck','Nephews','Squeak'];
        $imgCanard =['canarchiste.jpg', 'donald.jpg', 'canard-avion.jpg', 'canard-banane.jpg', 'canard-gonflable.jpg', 'journal-canard.jpg'];
        
        for ($i = 0; $i < 100; $i++) {
            $canard = new Products();
            $canardRace = $faker->randomElement($raceCanard);
            $name = $faker->randomElement($nameCanard) . ' ' . 'le' . ' ' . $canardRace;
            $canard->setNameProducts($name);
            $canard->setPrice($faker->numberBetween(5, 50));
            $canard->setGamme($faker->randomElement($gammes));

            // Ajoutons quelques caractéristiques spécifiques aux canards
            $color = $faker->randomElement($colors);
            $size = $faker->randomElement($sizes);
            $canard->setDescription("Je suis de la race des $canardRace de taille plutot $size et de couleur $color");

            // Set the slug based on the nameProducts
            $slug = $this->slugger->slug($name)->lower();
            $canard->setSlug($slug);

            $manager->persist($canard);
            $numImages = $faker->numberBetween(2, 5);

            // Créer et associer des images de canards à ce produit
            for ($j = 0; $j < $numImages; $j++) {
                $selectedImage = $faker->randomElement($imgCanard);
            
                $picture = new Pictures();
                $picture->setNamePicture($selectedImage);
                $picture->setProducts($canard);
                $manager->persist($picture);
            }
        }

        $manager->flush();
    }
   
}
