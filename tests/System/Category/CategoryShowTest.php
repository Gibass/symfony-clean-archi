<?php

namespace System\Category;

use App\Tests\Common\Listing\ListingTestDetails;
use App\Tests\Common\Listing\ListingTestTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryShowTest extends WebTestCase
{
    use ListingTestTrait;

    /**
     * @dataProvider dataSuccessfulProvider
     */
    public function testCategoryShowSuccessResponse(ListingTestDetails $details): void
    {
        $crawler = $this->listingSuccessResponse($details);

        $this->assertSelectorCount(1, 'aside .category-widget ul li');
        $this->assertSame('(3)', $crawler->filter('aside .category-widget li:nth-child(1) a small')->html());

        $this->assertSelectorCount(2, 'aside .tag-widget ul li');
        $this->assertSame('/tag/photo', $crawler->filter('aside .tag-widget li:nth-child(1) a')->attr('href'));

        $this->assertSelectorCount(3, 'aside .last-post-widget ul .widget-post');
        $this->assertSame('Stock - 55', $crawler->filter('aside .last-post-widget .widget-post:nth-child(1) .media-body a')->html());
    }

    public static function dataSuccessfulProvider(): \Generator
    {
        // Category
        yield 'test_show_category_men_first_page' => [
            ListingTestDetails::create('/category/men', [
                'element' => 'article',
                'count' => 3,
                'asserts' => [
                    'firstId' => 'article-3',
                    'LastId' => 'article-1',
                ],
            ]),
        ];

        yield 'test_show_category_empty_no_content' => [
            ListingTestDetails::create('/category/empty-cat', [
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
