<?php

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Infrastructure\Doctrine\Factory\ArticleDoctrineFactory;
use App\Infrastructure\Doctrine\Factory\TagDoctrineFactory;
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
        // Tag
        $photo = TagDoctrineFactory::createOne(['title' => 'Photo']);
        $image = TagDoctrineFactory::createOne(['title' => 'Image']);

        ArticleDoctrineFactory::new([
            'title' => 'Custom Title',
            'content' => 'This is the article content',
            'tags' => [
                $photo,
                $image,
            ],
            'createdAt' => \DateTime::createFromFormat('Y-m-d H:i:s', '2023-05-15 01:00:00'),
        ])->published()->create();

        ArticleDoctrineFactory::new()
            ->published()
            ->sequence(function () use ($photo) {
                $date = new \DateTimeImmutable('2023-05-15 01:00:00');
                foreach (range(1, 2) as $i) {
                    yield [
                        'tags' => [$photo],
                        'createdAt' => $date->modify('+' . $i . ' hour'),
                    ];
                }
            })
            ->create()
        ;

        ArticleDoctrineFactory::new()
            ->published()
            ->sequence(function () use ($image) {
                $date = new \DateTimeImmutable('2023-05-15 03:15:00');
                foreach (range(1, 2) as $i) {
                    yield [
                        'tags' => [$image],
                        'createdAt' => $date->modify('+' . $i . ' hour'),
                    ];
                }
            })
            ->create()
        ;

        // Unpublished
        ArticleDoctrineFactory::new(['tags' => [$image]])->unpublished()->create();
        ArticleDoctrineFactory::new(['tags' => [$photo]])->unpublished()->create();
        ArticleDoctrineFactory::new('unpublished', 'noTag')->create();

        // Stock
        ArticleDoctrineFactory::new()
            ->published()
            ->noTag()
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
