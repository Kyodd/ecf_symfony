<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $userPasswordHasherInterface, private SluggerInterface $slugger)
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $Kyodd = new User();
        $Kyodd->setEmail('kyodd@landeraus.fr');
        $Kyodd->setRoles(['ROLE_ADMIN']);
        $Kyodd->setPassword($this->userPasswordHasherInterface->hashPassword($Kyodd, 'kyodd'));

        $Kyodd->setNom('Kyodd');
        $Kyodd->setPrenom('Kyodd');
        $Kyodd->setBirthdate(new \DateTime('1999-12-12'));
        $Kyodd->setAdresse('12 rue de la bite');
        $Kyodd->setCodepostal('75000');
        $Kyodd->setVille('Paris');
        $Kyodd->setPhonenumber('0123456789');

        $manager->persist($Kyodd);

        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($this->userPasswordHasherInterface->hashPassword($user, 'password'));

            $user->setNom($faker->lastName);
            $user->setPrenom($faker->firstName);
            $user->setBirthdate($faker->dateTimeBetween('-50 years', '-18 years'));
            $user->setAdresse($faker->streetAddress);
            $user->setCodepostal(str_replace(' ', '', $faker->postcode));
            $user->setVille($faker->city);
            $user->setPhonenumber($faker->phoneNumber);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
