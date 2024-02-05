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
        $this->assertStringContainsString('/02-2024/image-custom.jpg', $crawler->filter('article#article-1 .post-slider img')->attr('src'));
    }

    public function testShowArticleWithNoMediaSuccess(): void
    {
        $client = static::createClient();

        $client->request('GET', 'article/3.html');

        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('article#article-3 h1.title', 'No Media');
        $this->assertSelectorTextContains('article#article-3 div.content', 'This is the article content with no Media');
        $this->assertSelectorTextContains('article#article-3 .post-meta .list-inline-item:nth-child(2)', 'May 15, 2023');
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
            'url' => 'article/2.html',
            'exception' => NotFoundHttpException::class,
        ];
    }
}
