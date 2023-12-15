<?php

namespace App\DataFixtures;

use App\Factory\DrivingSessionBookingFactory;
use App\Factory\InstructorFactory;
use App\Factory\StudentFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        StudentFactory::createMany(25);
        InstructorFactory::createMany(3);
        DrivingSessionBookingFactory::createMany(
            15,
            function () {
                return [
                    'student' => StudentFactory::random(),
                    'instructor' => InstructorFactory::random(),
                ];
            }
        );


        $manager->flush();
    }
}
