<?php

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Infrastructure\Doctrine\Factory\ArticleFactory;
use App\Infrastructure\Doctrine\Factory\CategoryFactory;
use App\Infrastructure\Doctrine\Factory\TagFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        TagFactory::createMany(20);
        CategoryFactory::createMany(5);
        ArticleFactory::createMany(100);
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }
}
