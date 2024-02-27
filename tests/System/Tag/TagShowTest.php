<?php

namespace System\Tag;

use App\Tests\Common\Listing\ListingTestDetails;
use App\Tests\Common\Listing\ListingTestTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TagShowTest extends WebTestCase
{
    use ListingTestTrait;

    /**
     * @dataProvider dataSuccessfulProvider
     */
    public function testTagShowSuccessResponse(ListingTestDetails $details): void
    {
        $crawler = $this->listingSuccessResponse($details);
    }

    public static function dataSuccessfulProvider(): \Generator
    {
        // Tag
        yield 'test_listing_with_photo_tag_first_page' => [
            ListingTestDetails::create('/tag/photo', [
                'element' => 'article',
                'count' => 3,
                'asserts' => [
                    'firstId' => 'article-3',
                    'LastId' => 'article-1',
                ],
            ]),
        ];

        yield 'test_listing_with_image_tag_first_page' => [
            ListingTestDetails::create('/tag/image', [
                'element' => 'article',
                'count' => 3,
                'asserts' => [
                    'firstId' => 'article-5',
                    'LastId' => 'article-1',
                ],
            ]),
        ];

        yield 'test_listing_with_no_content_empty_tag' => [
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
