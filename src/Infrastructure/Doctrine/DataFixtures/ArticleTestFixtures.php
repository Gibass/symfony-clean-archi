<?php

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Infrastructure\Doctrine\Factory\ArticleDoctrineFactory;
use App\Infrastructure\Doctrine\Factory\CategoryDoctrineFactory;
use App\Infrastructure\Doctrine\Factory\TagDoctrineFactory;
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
        $photo = TagDoctrineFactory::createOne(['title' => 'Photo']);
        $image = TagDoctrineFactory::createOne(['title' => 'Image']);

        // Category
        $men = CategoryDoctrineFactory::createOne(['title' => 'Men']);

        ArticleDoctrineFactory::new([
            'title' => 'Custom Title',
            'content' => 'This is the article content',
            'category' => $men,
            'tags' => [
                $photo,
                $image,
            ],
            'createdAt' => \DateTime::createFromFormat('Y-m-d H:i:s', '2023-05-15 01:00:00'),
        ])->published()->create();

        ArticleDoctrineFactory::new()
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

        ArticleDoctrineFactory::new()
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

        // Unpublished
        ArticleDoctrineFactory::new(['tags' => [$image]])->unpublished()->create();
        ArticleDoctrineFactory::new(['tags' => [$photo], 'category' => $men])->unpublished()->create();
        ArticleDoctrineFactory::new('unpublished', 'noTaxonomy')->create();

        // Stock
        ArticleDoctrineFactory::new()
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
