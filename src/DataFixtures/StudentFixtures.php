<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $students = new Student();
         $students->setAdmissionNumber('Stud1');
         $students->setClassId($this->getReference('cl_1'));
         $manager->persist($students);
         $manager->flush();
    }
}
