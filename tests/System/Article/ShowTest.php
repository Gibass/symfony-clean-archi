<?php

namespace System\Article;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowTest extends WebTestCase
{
    public function testShowArticleSuccess(): void
    {
        $client = static::createClient();

        $client->request('GET', 'article/1.html');

        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('article#article-1 h1.title', 'Custom Title');
        $this->assertSelectorTextContains('article#article-1 div.content', 'This is the article content');
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
