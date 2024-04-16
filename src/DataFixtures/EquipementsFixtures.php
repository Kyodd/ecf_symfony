<?php

namespace App\DataFixtures;

use App\Repository\EquipementRepository;
use Faker\Factory;
use App\Repository\SalleRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class EquipementsFixtures extends Fixture
{
    public function __construct(private SalleRepository $salleRepo,private EquipementRepository $equipementRepo )
    {
        
    } 
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        // $equips = [];
       
        // $salles = $this->salleRepo->findAll();
        // $equipements= $this->equipementRepo->findAll();
       
        // $equips[]= $equipements;
        // foreach($salles as $salle){
        //     for($i = 0; $i < mt_rand(1, 5); $i++){
        //         $salle->addEquipement($equips[mt_rand(0, count($equips) - 1)]
        //     );
        //     }
        // }
        // $manager->flush();
    }
}
