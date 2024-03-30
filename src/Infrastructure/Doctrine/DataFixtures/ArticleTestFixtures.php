<?php

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Infrastructure\Doctrine\Factory\ArticleFactory;
use App\Infrastructure\Doctrine\Factory\CategoryFactory;
use App\Infrastructure\Doctrine\Factory\TagFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ArticleTestFixtures extends Fixture implements FixtureGroupInterface
{
    public const NB_TOTAL = 63;

    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        // Tag
        $photo = TagFactory::createOne(['title' => 'Photo']);
        $image = TagFactory::createOne(['title' => 'Image']);

        // Category
        $men = CategoryFactory::createOne(['title' => 'Men']);

        ArticleFactory::new([
            'title' => 'Custom Title',
            'content' => 'This is the article content',
            'category' => $men,
            'tags' => [
                $photo,
                $image,
            ],
            'createdAt' => \DateTime::createFromFormat('Y-m-d H:i:s', '2023-05-15 01:00:00'),
        ])->published()->create();

        ArticleFactory::new()
            ->published()
            ->sequence(function () use ($photo, $men) {
                $date = new \DateTimeImmutable('2023-05-15 01:00:00');
                foreach (range(1, 2) as $i) {
                    yield [
                        'tags' => [$photo],
                        'category' => $men,
                        'createdAt' => $date->modify('+' . $i . ' hour'),
                    ];
                }
            })
            ->create()
        ;

        ArticleFactory::new()
            ->published()
            ->noCategory()
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

        $date = \DateTime::createFromFormat('Y-m-d H:i:s', '2024-03-20 01:00:00');

        // Unpublished
        ArticleFactory::new(['tags' => [$image], 'createdAt' => $date->modify('+1 hour')])->unpublished()->create();
        ArticleFactory::new(['tags' => [$photo], 'category' => $men, 'createdAt' => $date->modify('+1 hour')])->unpublished()->create();
        ArticleFactory::new(['createdAt' => $date->modify('+1 hour')])->unpublished()->noTaxonomy()->create();

        // Stock
        ArticleFactory::new()
            ->published()
            ->noTaxonomy()
            ->sequence(function () {
                $date = new \DateTimeImmutable('2023-05-15');
                foreach (range(1, 55) as $i) {
                    yield [
                        'title' => 'Stock - ' . $i,
                        'createdAt' => $date->modify('+' . $i . ' day'),
                    ];
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
