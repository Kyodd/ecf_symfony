<?php
// src/DataFixtures/LivreFixtures.php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Etat;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EtatFixtures extends Fixture 
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
$state =["excellent","bon", "moyen", "mauvais"];
        // Créer 4 livres factices
        foreach ($state as $libelle) {
            $etat = new Etat();
            $etat->setLibelle($libelle);
            $manager->persist($etat);
        }

        $manager->flush();
    }
   
}
