<?php

namespace App\Tests\Integration\Tag;

use App\Infrastructure\Test\IntegrationTestCase;
use App\Tests\Common\Listing\ListingTestDetails;
use App\Tests\Common\Listing\ListingTestTrait;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TagShowTest extends IntegrationTestCase
{
    use ListingTestTrait;

    /**
     * @dataProvider dataSuccessfulProvider
     */
    public function testTagShowSuccessResponse(ListingTestDetails $details): void
    {
        $crawler = $this->listingSuccessResponse($details);

        $this->assertSelectorCount(2, 'aside .category-widget ul li');
        $this->assertSame('(3)', $crawler->filter('aside .category-widget li:nth-child(1) a small')->html());

        $this->assertSelectorCount(3, 'aside .tag-widget ul li');
        $this->assertSame('/tag/image', $crawler->filter('aside .tag-widget li:nth-child(1) a')->attr('href'));

        $this->assertSelectorCount(3, 'aside .last-post-widget ul .widget-post');
        $this->assertSame('Custom title', $crawler->filter('aside .last-post-widget .widget-post:nth-child(1) .media-body a')->html());
    }

    public static function dataSuccessfulProvider(): \Generator
    {
        // Tag
        yield 'test_show_tag_photo_first_page' => [
            ListingTestDetails::create('/tag/photo', [
                'element' => 'article',
                'count' => 5,
                'asserts' => [
                    'firstId' => 'article-6',
                    'LastId' => 'article-10',
                ],
            ]),
        ];

        yield 'test_show_tag_image_first_page' => [
            ListingTestDetails::create('/tag/image', [
                'element' => 'article',
                'count' => 5,
                'asserts' => [
                    'firstId' => 'article-1',
                    'LastId' => 'article-5',
                ],
            ]),
        ];

        yield 'test_show_tag_empty_no_content' => [
            ListingTestDetails::create('/tag/empty', [
                'element' => 'article',
                'count' => 0,
            ]),
        ];
    }

    public static function dataFailedProvider(): \Generator
    {
        yield 'test_show_tag_with_no_existing_tag' => [
            ListingTestDetails::create('/tag/no-tag', [
                'exception' => NotFoundHttpException::class,
            ]),
        ];
    }
}
