<?php

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Infrastructure\Doctrine\Factory\ArticleDoctrineFactory;
use App\Infrastructure\Doctrine\Factory\CategoryDoctrineFactory;
use App\Infrastructure\Doctrine\Factory\TagDoctrineFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        TagDoctrineFactory::createMany(20);
        CategoryDoctrineFactory::createMany(5);
        ArticleDoctrineFactory::createMany(100);
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }
}
