<?php

namespace System\Article;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowTest extends WebTestCase
{
    public function testShowArticleSuccess(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'article/1.html');

        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('article#article-1 h1.title', 'Custom Title');
        $this->assertSelectorTextContains('article#article-1 div.content', 'This is the article content');
        $this->assertSelectorTextContains('article#article-1 .post-meta .list-inline-item:nth-child(2)', 'May 15, 2023');
        $this->assertStringContainsString('tag/photo', $crawler->filter('ul.post-meta li:last-child a:nth-child(1)')->attr('href'));
        $this->assertStringContainsString('Image', $crawler->filter('ul.post-meta li:last-child a:last-child')->html());
    }

    /**
     * @dataProvider dataFailedShowProvider
     */
    public function testShowFailed(string $url, string $exception): void
    {
        $client = static::createClient();

        $client->catchExceptions(false);
        $this->expectException($exception);

        $client->request('GET', $url);

        $this->assertResponseStatusCodeSame(404);
    }

    public static function dataFailedShowProvider(): \Generator
    {
        yield 'testShowWithNotFoundArticle' => [
            'url' => 'article/0.html',
            'exception' => NotFoundHttpException::class,
        ];

        yield 'testShowWithUnpublishedArticle' => [
            'url' => 'article/6.html',
            'exception' => NotFoundHttpException::class,
        ];
    }
}
