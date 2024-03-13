<?php

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Infrastructure\Doctrine\Factory\UserDoctrineFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class UserTestFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        UserDoctrineFactory::createOne([
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'test@test.com',
            'plainPassword' => 'password',
        ]);
    }

    public static function getGroups(): array
    {
        return ['test'];
    }
}
