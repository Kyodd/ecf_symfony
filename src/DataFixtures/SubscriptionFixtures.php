<?php

namespace App\DataFixtures;

use App\Entity\SubscriptionType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SubscriptionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $subType = [];

        $monthly = new SubscriptionType();
        $monthly->setName('Monthly');
        $monthly->setPrice('23.99');
        $manager->persist($monthly);
        $subType[] = $monthly;

        $yearly = new SubscriptionType();
        $yearly->setName('Yearly');
        $yearly->setPrice('215.99');
        $manager->persist($yearly);
        $subType[] = $yearly;

        $manager->flush();
    }
}
