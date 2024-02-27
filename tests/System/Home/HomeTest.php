<?php

namespace System\Home;

use App\Tests\Common\Listing\ListingTestDetails;
use App\Tests\Common\Listing\ListingTestTrait;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeTest extends WebTestCase
{
    use ListingTestTrait;

    /**
     * @dataProvider dataSuccessfulProvider
     */
    public function testHomeSuccessResponse(ListingTestDetails $details): void
    {
        $crawler = $this->listingSuccessResponse($details);
    }

    public static function dataSuccessfulProvider(): \Generator
    {
        // Home
        yield 'test_listing_home_first_page' => [
            ListingTestDetails::create('/', [
                'element' => 'article',
                'count' => 10,
                'asserts' => [
                    'firstId' => 'article-63',
                    'LastId' => 'article-54',
                ],
            ]),
        ];

        yield 'test_listing_home_last_page' => [
            ListingTestDetails::create('/?page=6', [
                'element' => 'article',
                'count' => 10,
                'asserts' => [
                    'firstId' => 'article-13',
                    'LastId' => 'article-1',
                ],
            ]),
        ];

        yield 'test_listing_home_invalid_page_return_first_page' => [
            ListingTestDetails::create('/?page=oops', [
                'element' => 'article',
                'count' => 10,
                'asserts' => [
                    'firstId' => 'article-63',
                    'LastId' => 'article-54',
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