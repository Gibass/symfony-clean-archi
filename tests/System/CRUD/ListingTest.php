<?php

namespace System\CRUD;

use App\Tests\Common\Listing\ListingTestDetails;
use App\Tests\Common\Listing\ListingTestTrait;
use App\Tests\Common\Logged\LoggedTest;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ListingTest extends WebTestCase
{
    use ListingTestTrait;
    use LoggedTest;

    /**
     * @dataProvider dataSuccessfulProvider
     */
    public function testListingSuccessResponse(ListingTestDetails $details): void
    {
        $this->listingSuccessResponse($details);
    }

    public static function dataSuccessfulProvider(): \Generator
    {
        // Articles
        yield 'test_listing_articles_first_page' => [
            ListingTestDetails::create('/admin/listing/articles', [
                'element' => 'table .items-rows',
                'count' => 50,
                'asserts' => [
                    'attrSelector' => 'class',
                    'firstSelector' => 'table tr.items-rows:nth-child(1)',
                    'lastSelector' => 'table tr.items-rows:last-child',
                    'firstId' => 'article-8',
                    'LastId' => 'article-17',
                ],
            ]),
        ];
    }

    public static function dataFailedProvider(): \Generator
    {
        yield 'test_listing_articles_no_content' => [
            ListingTestDetails::create('/admin/listing/articles?page=20', [
                'exception' => OutOfRangeCurrentPageException::class,
            ]),
        ];
    }
}