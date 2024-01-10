<?php
// src/DataFixtures/GammeFixture.php
namespace App\DataFixtures;

use App\Entity\Gamme;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;

class GammeFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $gammeCanard = ['Canards Sauvages','Collection Plumes Dorées','Canards Aquatiques','Variété Mallard','Canards en Parade',];
        foreach ($gammeCanard as $nomGamme) {
            $gamme = new Gamme();
            $gamme->setNameGamme($nomGamme);
        
            $manager->persist($gamme);
        }
        

        $manager->flush();
    }
}
