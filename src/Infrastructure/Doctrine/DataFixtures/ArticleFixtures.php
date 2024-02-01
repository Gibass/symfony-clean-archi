<?php

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Infrastructure\Doctrine\Entity\ArticleDoctrine;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends Fixture implements FixtureGroupInterface
{
    private \Faker\Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 20; ++$i) {
            $article = new ArticleDoctrine();
            $article->setTitle($this->faker->sentence(4))
                ->setSlug($this->faker->slug(4))
                ->setContent($this->faker->paragraph)
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-1 year')))
            ;

            if ($this->faker->boolean(75)) {
                $article->setUpdatedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween($article->getCreatedAt()->format('c'))));
            }

            if ($this->faker->boolean(35)) {
                $end = $article->getUpdatedAt() ? $article->getUpdatedAt()->format('c') : 'now';
                $article->setStatus(true);
                $article->setPublishedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween(
                    $article->getCreatedAt()->format('c'),
                    $end,
                )));

                if ($end === 'now') {
                    $article->setUpdatedAt($article->getPublishedAt());
                }
            }

            $manager->persist($article);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }
}
