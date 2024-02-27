<?php

namespace App\Tests\Integration\Home;

use App\Infrastructure\Test\IntegrationTestCase;
use App\Tests\Common\Listing\ListingTestDetails;
use App\Tests\Common\Listing\ListingTestTrait;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;

class HomeTest extends IntegrationTestCase
{
    use ListingTestTrait;

    /**
     * @dataProvider dataSuccessfulProvider
     */
    public function testHomeSuccessResponse(ListingTestDetails $details): void
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
        // Home
        yield 'test_home_first_page' => [
            ListingTestDetails::create('/', [
                'element' => 'article',
                'count' => 10,
                'asserts' => [
                    'firstId' => 'article-1',
                    'LastId' => 'article-10',
                ],
            ]),
        ];

        yield 'test_home_last_page' => [
            ListingTestDetails::create('/?page=3', [
                'element' => 'article',
                'count' => 5,
                'asserts' => [
                    'firstId' => 'article-21',
                    'LastId' => 'article-25',
                ],
            ]),
        ];

        yield 'test_home_invalid_page_return_first_page' => [
            ListingTestDetails::create('/?page=oops', [
                'element' => 'article',
                'count' => 10,
                'asserts' => [
                    'firstId' => 'article-1',
                    'LastId' => 'article-10',
                ],
            ]),
        ];
    }

    public static function dataFailedProvider(): \Generator
    {
        yield 'test_home_with_no_content_found' => [
            ListingTestDetails::create('/?page=20', [
                'exception' => OutOfRangeCurrentPageException::class,
            ]),
        ];
    }
}
