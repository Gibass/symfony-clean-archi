<?php

namespace Integration\Tag;

use App\Infrastructure\Test\IntegrationTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ListingTest extends IntegrationTestCase
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
            $this->assertStringContainsString('article-' . $firstId, $crawler->filter('.article-content article:nth-child(1)')->attr('id'));
            $this->assertStringContainsString('article-' . $lastId, $crawler->filter('.article-content article:last-child')->attr('id'));
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
            'count' => 5,
            'firstId' => 6,
            'lastId' => 10,
        ];

        yield 'test_page_with_image_tag' => [
            'url' => '/tag/image',
            'count' => 5,
            'firstId' => 1,
            'lastId' => 5,
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
        yield 'test_page_with_no_existing_tag' => [
            'url' => '/tag/no-tag',
        ];
    }
}
