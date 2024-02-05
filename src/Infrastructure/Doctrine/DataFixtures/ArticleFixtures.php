<?php

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Infrastructure\Doctrine\Entity\ArticleDoctrine;
use App\Infrastructure\Doctrine\Entity\ImageDoctrine;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Filesystem\Filesystem;

class ArticleFixtures extends Fixture implements FixtureGroupInterface
{
    private \Faker\Generator $faker;
    private Filesystem $fileSystem;

    public function __construct(private readonly string $uploadDir)
    {
        $this->faker = Factory::create();
        $this->fileSystem = new Filesystem();
    }

    public function load(ObjectManager $manager): void
    {
        $this->fileSystem->remove($this->uploadDir . '/test');
        $this->fileSystem->mkdir($this->uploadDir . '/test');

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

            $image = (new ImageDoctrine())
                ->setTitle($this->faker->title)
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-1 year')))
                ->setPath(str_replace($this->uploadDir, '', $this->faker->image($this->uploadDir . '/test', 1200, 650)))
            ;

            $manager->persist($image);

            if ($this->faker->boolean(75)) {
                $image->setUpdatedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween($image->getCreatedAt()->format('c'))));
                $article->setMainMedia($image);
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
