<?php
// UserFixture.php
namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager)
    {
        
        $faker = Factory::create();

        $admin = new User();
        $admin->setName($faker->lastName);
        $admin->setFirstName($faker->firstName);
        $admin->setEmail('admin@admin.fr'); 
        $admin->setAddress($faker->address);
        $admin->setPseudo($faker->userName);
        $admin->setCity($faker->city);
        $admin->setRoles(['ROLE_ADMIN']); 
        $admin->setPassword($this->passwordHasher->hashPassword($admin, '123456789')); 

        $manager->persist($admin);

        for ($i = 0; $i < 100; $i++) {
            $user = new User();
            $user->setName($faker->lastName);
            $user->setFirstName($faker->firstName);
            $user->setEmail($faker->unique()->email); 
            $user->setAddress($faker->address);
            $user->setPseudo($faker->userName);
            $user->setCity($faker->city);
            $user->setRoles(['ROLE_USER']); 
            $user->setPassword($this->passwordHasher->hashPassword($user, 'user123')); 
            $manager->persist($user);
        }

        $manager->flush();
    }
}
