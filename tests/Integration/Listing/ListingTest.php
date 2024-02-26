<?php

namespace App\Tests\Integration\Listing;

use App\Infrastructure\Test\IntegrationTestCase;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ListingTest extends IntegrationTestCase
{
    /**
     * @dataProvider dataSuccessfulProvider
     */
    public function testListingSuccessResponse(ListingTestDetails $details): void
    {
        $client = self::createClient();

        $crawler = $client->request('GET', $details->getUrl());

        $this->assertResponseIsSuccessful();

        $this->assertSelectorCount($details->getCount(), $details->getElement());

        if ($details->getCount() > 0 && $details->hasAssert()) {
            $this->assertStringContainsString($details->getFistElementId(), $crawler->filter($details->getFistSelector())->attr($details->getAttrSelector()));
            $this->assertStringContainsString($details->getLastElementId(), $crawler->filter($details->getLastSelector())->attr($details->getAttrSelector()));
        }
    }

    public static function dataSuccessfulProvider(): \Generator
    {
        // Home
        yield 'test_listing_home_first_page' => [
            ListingTestDetails::create('/', [
                'element' => 'article',
                'count' => 10,
                'asserts' => [
                    'firstId' => 'article-1',
                    'LastId' => 'article-10',
                ],
            ]),
        ];

        yield 'test_listing_home_last_page' => [
            ListingTestDetails::create('/?page=3', [
                'element' => 'article',
                'count' => 5,
                'asserts' => [
                    'firstId' => 'article-21',
                    'LastId' => 'article-25',
                ],
            ]),
        ];

        yield 'test_listing_home_invalid_page_return_first_page' => [
            ListingTestDetails::create('/?page=oops', [
                'element' => 'article',
                'count' => 10,
                'asserts' => [
                    'firstId' => 'article-1',
                    'LastId' => 'article-10',
                ],
            ]),
        ];

        // Tag
        yield 'test_listing_tag_photo_first_page' => [
            ListingTestDetails::create('/tag/photo', [
                'element' => 'article',
                'count' => 5,
                'asserts' => [
                    'firstId' => 'article-6',
                    'LastId' => 'article-10',
                ],
            ]),
        ];

        yield 'test_listing_tag_image_first_page' => [
            ListingTestDetails::create('/tag/image', [
                'element' => 'article',
                'count' => 5,
                'asserts' => [
                    'firstId' => 'article-1',
                    'LastId' => 'article-5',
                ],
            ]),
        ];

        yield 'test_listing_tag_empty_no_content' => [
            ListingTestDetails::create('/tag/empty', [
                'element' => 'article',
                'count' => 0,
            ]),
        ];

        // Category
        yield 'test_listing_category_men_first_page' => [
            ListingTestDetails::create('/category/men', [
                'element' => 'article',
                'count' => 5,
                'asserts' => [
                    'firstId' => 'article-1',
                    'LastId' => 'article-5',
                ],
            ]),
        ];

        yield 'test_listing_category_empty_no_content' => [
            ListingTestDetails::create('/category/empty', [
                'element' => 'article',
                'count' => 0,
            ]),
        ];
    }

    /**
     * @dataProvider dataFailedProvider
     */
    public function testListingFailedResponse(ListingTestDetails $details): void
    {
        $client = self::createClient();

        $client->catchExceptions(false);
        $this->expectException($details->getExceptionClass());

        $client->request('GET', $details->getUrl());

        $this->assertResponseStatusCodeSame(404);
    }

    public static function dataFailedProvider(): \Generator
    {
        yield 'test_listing_home_with_no_content_found' => [
            ListingTestDetails::create('/?page=20', [
                'exception' => OutOfRangeCurrentPageException::class,
            ]),
        ];

        yield 'test_listing_with_no_existing_tag' => [
            ListingTestDetails::create('/tag/no-tag', [
                'exception' => NotFoundHttpException::class,
            ]),
        ];

        yield 'test_listing_with_no_existing_category' => [
            ListingTestDetails::create('/category/no-category', [
                'exception' => NotFoundHttpException::class,
            ]),
        ];
    }
}
