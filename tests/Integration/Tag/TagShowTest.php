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
