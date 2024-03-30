<?php

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Infrastructure\Doctrine\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class UserTestFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'test@test.com',
            'plainPassword' => 'password',
            'isVerified' => true,
        ]);

        UserFactory::createOne([
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'unverified@test.com',
            'plainPassword' => 'password',
            'isVerified' => false,
        ]);
    }

    public static function getGroups(): array
    {
        return ['test'];
    }
}
