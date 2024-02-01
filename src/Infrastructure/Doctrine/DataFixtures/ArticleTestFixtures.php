<?php

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Infrastructure\Doctrine\Entity\ArticleDoctrine;
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
        $article = new ArticleDoctrine();

        $article->setTitle('Custom Title')
            ->setSlug('custom-article')
            ->setContent('This is the article content')
            ->setStatus(1)
            ->setPublishedAt(\DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-05-15 22:15:52'))
            ->setUpdatedAt(\DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-05-15 22:15:52'))
            ->setCreatedAt(\DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-02-25 18:16:42'))
        ;

        $manager->persist($article);


        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['test'];
    }
}
