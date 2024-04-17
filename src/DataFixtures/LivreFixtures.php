<?php
// src/DataFixtures/LivreFixtures.php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Livre;
use App\DataFixtures\EtatFixtures;
use App\Repository\EtatRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LivreFixtures extends Fixture implements DependentFixtureInterface //
{
    public function __construct(private EtatRepository $etatRepo)
    { 

    }
    public function load(ObjectManager $manager):void //injecter 
    {
        $faker = Factory::create();
        $etat = $this->etatRepo->findAll();
        // Créer 10 livres factices
        for ($i = 0; $i < 100; $i++) {
            $livre = new Livre();
            $livre->setNom($faker->sentence(3));
            $livre->setAuteur($faker->name);
            $livre->setAnneePublication($faker->year);
            $livre->setResume($faker->paragraph);
            $livre->setImage($faker->imageUrl(400, 300, 'books'));
            $livre->setDisponibilite($faker->boolean);
            $livre->setNote($faker->numberBetween(1, 5));
            $livre->setEtat($faker->randomElement($etat));
            // Ajoutez d'autres propriétés du livre selon vos besoins

            $manager->persist($livre);
        }

        $manager->flush();
    }
    public function getDependencies():array
    {
        return [
            EtatFixtures::class,
        ];
    } 
}
