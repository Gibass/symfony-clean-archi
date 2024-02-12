<?php

namespace System\Home;

use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ListingTest extends WebTestCase
{
    /**
     * @dataProvider dataListingProvider
     */
    public function testHomeListing(string $url, int $count, ?int $firstId, ?int $lastId): void
    {
        $client = self::createClient();

        $crawler = $client->request('GET', $url);

        $this->assertResponseIsSuccessful();

        $this->assertSelectorCount($count, 'article');

        if ($count > 0) {
            $this->assertStringContainsString('article-' . $firstId, $crawler->filter('article:nth-child(1)')->attr('id'));
            $this->assertStringContainsString('article-' . $lastId, $crawler->filter('article:last-child')->attr('id'));
        }
    }

    /**
     * @dataProvider dataListingFailedProvider
     */
    public function testHomeListWithNotFoundPage(string $url): void
    {
        $client = self::createClient();

        $client->catchExceptions(false);
        $this->expectException(OutOfRangeCurrentPageException::class);

        $client->request('GET', $url);

        $this->assertResponseStatusCodeSame(404);
    }

    public static function dataListingProvider(): \Generator
    {
        yield 'test_first_page_return_10_first_article' => [
            'url' => '/',
            'count' => 10,
            'firstId' => 57,
            'lastId' => 48,
        ];

        yield 'test_next_page_return_10_next_article' => [
            'url' => '/?page=2',
            'count' => 10,
            'firstId' => 47,
            'lastId' => 38,
        ];

        yield 'test_last_page_return_6_last_article' => [
            'url' => '/?page=6',
            'count' => 6,
            'firstId' => 7,
            'lastId' => 1,
        ];

        yield 'test_with_invalid_page' => [
            'url' => '/?page=oops',
            'count' => 10,
            'firstId' => 57,
            'lastId' => 48,
        ];
    }

    public static function dataListingFailedProvider(): \Generator
    {
        yield 'test_with_no_content_found_in_the page' => [
            'url' => '/?page=20',
        ];
    }
}
