<?php

namespace App\DataFixtures;

use App\Entity\Classes;
use App\Entity\Student;
use App\Entity\User;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder;


class DataFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
    // {
    //      $user= new User();
    //      $user->setUsername('admin');
    //      $user->setPassword('0000');

    //      $user->setEmail('no-reply$gmail.com');

    //      $manager->persist($user);
    //      $manager->flush();
       
        // $user = new User();
        // $user->setUsername("Admin");
        // $user->setPassword("123");
        // $manager->persist($user);
        // $manager->flush();
        
        // $user1= new Users();
        // $user1->setPassword('Abc@1');
        // $user1->setUserName('Savinder');
        // $manager->persist($user1);
        // $manager->flush();

        // $user2= new Users();
        // $user2->setName('Rahul');
        // $user2->setPassword('Rahul@1');
        // $user2->setRole('Teacher');
        // $user2->setUserType('Employee');
        // $user2->setUserName('Rahul');
        // $manager->persist($user2);
        // $manager->flush();

        // $user3= new Users();
        // $user3->setName('Takveer');
        // $user3->setPassword('Takveer@1');
        // $user3->setRole('Student');
        // $user3->setUserType('Student');
        // $user3->setUserName('Takveer');
        // $manager->persist($user3);
        // $manager->flush();

        // $user4= new Users();
        // $user4->setName('Nitish');
        // $user4->setPassword('Nitish@1');
        // $user4->setRole('Student');
        // $user4->setUserType('Student');
        // $user4->setUserName('Nitish');
        // $manager->persist($user4);
        // $manager->flush();

        // $class1 = new Classes();
        // $class1->setName('A1');
        // $manager->persist($class1);
        // $manager->flush();

        // $class2 = new Classes();
        // $class2->setName('A2');
        // $manager->persist($class2);
        // $manager->flush();

        //  $student1 = new Student();
        //  $student1->setAdmissionNumber('Stud1');
        //  $student1->setClassId($class1);
        //  $student1->setUserId($user3);
        //  $manager->persist($student1);
        //  $manager->flush();

        //  $student2 = new Student();
        //  $student2->setAdmissionNumber('Stud2');
        //  $student2->setClassId($class2);
        //  $student2->setUserId($user4);
        //  $manager->persist($student1);
        //  $manager->flush();
    }
}
