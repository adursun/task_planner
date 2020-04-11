<?php

namespace App\DataFixtures;

use App\Entity\Developer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 6; $i++) {
            $developer = new Developer();
            $developer->setName('Developer ' . $i);
            $developer->setHourlyWork($i);
            $manager->persist($developer);
        }

        $manager->flush();
    }
}
