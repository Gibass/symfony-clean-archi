<?php

namespace System\Tag;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ListingTest extends WebTestCase
{
    /**
     * @dataProvider dataListingProvider
     */
    public function testTagListing(string $url, int $count, ?int $firstId, ?int $lastId): void
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
    public function testTagListWithNotFoundPage(string $url): void
    {
        $client = self::createClient();

        $client->catchExceptions(false);
        $this->expectException(NotFoundHttpException::class);

        $client->request('GET', $url);

        $this->assertResponseStatusCodeSame(404);
    }

    public static function dataListingProvider(): \Generator
    {
        yield 'test_page_with_photo_tag' => [
            'url' => '/tag/photo',
            'count' => 3,
            'firstId' => 3,
            'lastId' => 1,
        ];

        yield 'test_page_with_image_tag' => [
            'url' => '/tag/image',
            'count' => 3,
            'firstId' => 5,
            'lastId' => 1,
        ];

        yield 'test_page_with_no_content_empty_tag' => [
            'url' => '/tag/empty',
            'count' => 0,
            'firstId' => 0,
            'lastId' => 0,
        ];
    }

    public static function dataListingFailedProvider(): \Generator
    {
        yield 'test_with_no_content_found_in_the page' => [
            'url' => '/tag/no-tag',
        ];
    }
}