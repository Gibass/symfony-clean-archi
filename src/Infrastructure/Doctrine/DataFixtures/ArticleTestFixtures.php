<?php

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Infrastructure\Doctrine\Factory\ArticleDoctrineFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ArticleTestFixtures extends Fixture implements FixtureGroupInterface
{
    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        ArticleDoctrineFactory::new([
            'title' => 'Custom Title',
            'content' => 'This is the article content',
            'createdAt' => \DateTime::createFromFormat('Y-m-d H:i:s', '2023-05-15 22:15:52'),
        ])->published()->create();

        ArticleDoctrineFactory::new('unpublished')->create();

        ArticleDoctrineFactory::new()
            ->published()
            ->sequence(function () {
                $date = new \DateTimeImmutable('2023-05-15');
                foreach (range(1, 55) as $i) {
                    yield ['createdAt' => $date->modify('+' . $i . ' day')];
                }
            })
            ->create()
        ;
    }

    public static function getGroups(): array
    {
        return ['test'];
    }
}
