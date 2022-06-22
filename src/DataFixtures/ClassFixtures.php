<?php

namespace App\DataFixtures;

use App\Entity\Classes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClassFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $classes = new Classes();
        $classes->setName('A1');
        $manager->persist($classes);
        $manager->flush();

        $this->addReference('cl_1',$classes);
    }
}
