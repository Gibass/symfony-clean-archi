<?php

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Infrastructure\Doctrine\Factory\CategoryFactory;
use App\Infrastructure\Doctrine\Factory\TagFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class TaxonomyTestFixtures extends Fixture implements FixtureGroupInterface
{
    public const CAT_NB_TOTAL = 2;
    public const TAG_NB_TOTAL = 3;

    public function load(ObjectManager $manager): void
    {
        TagFactory::createOne(['title' => 'Empty']);
        CategoryFactory::createOne(['title' => 'Empty Cat']);
    }

    public static function getGroups(): array
    {
        return ['test'];
    }
}
