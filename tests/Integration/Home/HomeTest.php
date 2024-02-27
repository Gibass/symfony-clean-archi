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