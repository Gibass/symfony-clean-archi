<?php

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Infrastructure\Doctrine\Entity\ArticleDoctrine;
use App\Infrastructure\Doctrine\Entity\ImageDoctrine;
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

        $image = (new ImageDoctrine())
            ->setTitle('Image Custom')
            ->setPath('/02-2024/image-custom.jpg')
            ->setCreatedAt(\DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-02-25 17:16:42'))
        ;

        $manager->persist($image);

        $article->setTitle('Custom Title')
            ->setSlug('custom-article')
            ->setContent('This is the article content')
            ->setStatus(1)
            ->setMainMedia($image)
            ->setPublishedAt(\DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-05-15 22:15:52'))
            ->setUpdatedAt(\DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-05-15 22:15:52'))
            ->setCreatedAt(\DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-02-25 18:16:42'))
        ;

        $manager->persist($article);

        $article = new ArticleDoctrine();

        $article->setTitle('Unpublished Title')
            ->setSlug('unpublished-article')
            ->setContent('This is the article content that not published')
            ->setUpdatedAt(\DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-04-18 21:05:52'))
            ->setCreatedAt(\DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-03-15 16:16:42'))
        ;

        $manager->persist($article);

        $article = new ArticleDoctrine();

        $article->setTitle('No Media')
            ->setSlug('custom-no-media-article')
            ->setContent('This is the article content with no Media')
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
