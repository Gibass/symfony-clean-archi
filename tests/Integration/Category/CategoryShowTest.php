<?php

namespace App\Tests\Integration\Category;

use App\Infrastructure\Test\IntegrationTestCase;
use App\Tests\Common\Listing\ListingTestDetails;
use App\Tests\Common\Listing\ListingTestTrait;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryShowTest extends IntegrationTestCase
{
    use ListingTestTrait;

    /**
     * @dataProvider dataSuccessfulProvider
     */
    public function testCategoryShowSuccessResponse(ListingTestDetails $details): void
    {
        $crawler = $this->listingSuccessResponse($details);
    }

    public static function dataSuccessfulProvider(): \Generator
    {
        // Category
        yield 'test_show_category_men_first_page' => [
            ListingTestDetails::create('/category/men', [
                'element' => 'article',
                'count' => 5,
                'asserts' => [
                    'firstId' => 'article-1',
                    'LastId' => 'article-5',
                ],
            ]),
        ];

        yield 'test_show_category_empty_no_content' => [
            ListingTestDetails::create('/category/empty', [
                'element' => 'article',
                'count' => 0,
            ]),
        ];
    }

    public static function dataFailedProvider(): \Generator
    {
        yield 'test_show_category_with_no_existing_category' => [
            ListingTestDetails::create('/category/no-category', [
                'exception' => NotFoundHttpException::class,
            ]),
        ];
    }
}
