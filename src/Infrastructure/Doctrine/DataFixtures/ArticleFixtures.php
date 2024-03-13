<?php

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Infrastructure\Doctrine\Entity\UserDoctrine;
use App\Infrastructure\Doctrine\Factory\ArticleDoctrineFactory;
use App\Infrastructure\Doctrine\Factory\CategoryDoctrineFactory;
use App\Infrastructure\Doctrine\Factory\TagDoctrineFactory;
use App\Infrastructure\Doctrine\Factory\UserDoctrineFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        UserDoctrineFactory::createMany(10);
        TagDoctrineFactory::createMany(20);
        CategoryDoctrineFactory::createMany(5);
        ArticleDoctrineFactory::createMany(100);
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }
}
