<?php

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Infrastructure\Doctrine\Entity\ArticleDoctrine;
use App\Infrastructure\Doctrine\Entity\ImageDoctrine;
use App\Infrastructure\Doctrine\Factory\ArticleDoctrineFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Filesystem\Filesystem;

class ArticleFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        ArticleDoctrineFactory::createMany(100);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }
}
