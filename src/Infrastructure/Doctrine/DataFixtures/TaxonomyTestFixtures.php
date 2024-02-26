<?php

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Infrastructure\Doctrine\Factory\CategoryDoctrineFactory;
use App\Infrastructure\Doctrine\Factory\TagDoctrineFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class TaxonomyTestFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        TagDoctrineFactory::createOne(['title' => 'Empty']);
        CategoryDoctrineFactory::createOne(['title' => 'Empty Cat']);
    }

    public static function getGroups(): array
    {
        return ['test'];
    }
}
