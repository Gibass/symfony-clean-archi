<?php

namespace App\Tests\Integration\Article;

use App\Infrastructure\Test\IntegrationTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowTest extends IntegrationTestCase
{
    public function testShowArticleSuccess(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'article/2.html');

        $this->assertResponseIsSuccessful();

        $this->assertStringContainsString('Custom Title', $crawler->html());
        $this->assertStringContainsString('Custom Content', $crawler->html());
        $this->assertStringContainsString('May 15, 2023', $crawler->html());
        $this->assertStringContainsString('tag/photo', $crawler->filter('ul.post-meta li:last-child a:nth-child(1)')->attr('href'));
        $this->assertStringContainsString('Image', $crawler->filter('ul.post-meta li:last-child a:last-child')->html());
    }

    public function testShowWithNotFoundArticle(): void
    {
        $client = static::createClient();

        $client->catchExceptions(false);
        $this->expectException(NotFoundHttpException::class);

        $client->request('GET', 'article/0.html');

        $this->assertResponseStatusCodeSame(404);
    }
}
