<?php

namespace App\DataFixtures;
use Faker\Factory;
use App\Entity\Salle;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SalleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 5; $i++) {
            $salle = new Salle();
            $salle->setNom('Salle ' . strval( $i + 1 ));
            $salle->setCapacite($faker->numberBetween(5,25));
            $manager->persist($salle);
        }
        $manager->flush();
    }

}
