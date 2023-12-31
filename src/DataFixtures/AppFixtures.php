<?php

namespace App\DataFixtures;

use App\Factory\DrivingSessionBookingFactory;
use App\Factory\InstructorFactory;
use App\Factory\StudentFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        UserFactory::createOne(['email' => 'admin@test.fr', 'password' => 'password', 'roles' => ['ROLE_ADMIN']]);
        InstructorFactory::createMany(3);
        StudentFactory::createOne(['email' => 'test@test.fr', 'assignedInstructor' => InstructorFactory::random()]);
        StudentFactory::createMany(120, ['assignedInstructor' => InstructorFactory::random()]);
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
