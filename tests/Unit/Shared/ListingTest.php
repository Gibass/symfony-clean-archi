<?php

namespace App\Tests\Unit\Shared;

use App\Domain\Article\Entity\Category;
use App\Domain\Article\Entity\Tag;
use App\Domain\Article\Gateway\ArticleGatewayInterface;
use App\Domain\Category\Exception\CategoryNotFoundException;
use App\Domain\Category\Gateway\CategoryGatewayInterface;
use App\Domain\Category\Request\ListingRequest as CategoryListingRequest;
use App\Domain\Category\Response\ListingResponse as CategoryListingResponse;
use App\Domain\Category\UseCase\CategoryListing;
use App\Domain\Home\Request\ListingRequest as HomeListingRequest;
use App\Domain\Home\Response\ListingResponse as HomeListingResponse;
use App\Domain\Home\UseCase\HomeListing;
use App\Domain\Shared\Listing\Exception\InvalidRequestException;
use App\Domain\Shared\Listing\Presenter\ListingPresenterInterface;
use App\Domain\Shared\Listing\Response\ListingResponseInterface;
use App\Domain\Shared\Listing\UseCase\ListingUseCase;
use App\Domain\Tag\Exception\TagNotFoundException;
use App\Domain\Tag\Gateway\TagGatewayInterface;
use App\Domain\Tag\Request\ListingRequest as TagListingRequest;
use App\Domain\Tag\Response\ListingResponse as TagListingResponse;
use App\Domain\Tag\UseCase\TagListing;
use Pagerfanta\Adapter\AdapterInterface;
use PHPUnit\Framework\TestCase;

class ListingTest extends TestCase
{
    private ListingUseCase $useCase;

    private ListingPresenterInterface $presenter;

    protected function setUp(): void
    {
        $this->presenter = new class() implements ListingPresenterInterface {
            public function present(ListingResponseInterface $response): ListingResponseInterface
            {
                return $response;
            }
        };

        $this->useCase = new ListingUseCase();
    }

    /**
     * @dataProvider dataSuccessfulProvider
     *
     * @throws \Exception
     */
    public function testListingSuccessful(ListingTestDetails $details): void
    {
        $gateway = $this->createMock($details->getGatewayClass());

        if ($details->hasCondition()) {
            $gateway->method($details->getConditionMethod())
                ->with($details->getConditionArgs())
                ->willReturn($details->getConditionReturn())
            ;
        }

        $adapter = $this->createMock(AdapterInterface::class);
        $gateway->method('getPaginatedAdapter')->willReturn($adapter);

        $response = $this->useCase->execute(
            $details->getRequest(),
            $details->getListing($gateway),
            $this->presenter
        );

        $this->assertInstanceOf($details->getResponseClass(), $response);
    }

    public static function dataSuccessfulProvider(): \Generator
    {
        yield 'test_listing_home_listing_success' => [ListingTestDetails::create(new HomeListingRequest(), [
            'listingClass' => HomeListing::class,
            'gatewayClass' => ArticleGatewayInterface::class,
            'responseClass' => HomeListingResponse::class,
        ])];

        yield 'test_listing_tag_listing_success' => [ListingTestDetails::create(new TagListingRequest('image'), [
            'listingClass' => TagListing::class,
            'gatewayClass' => TagGatewayInterface::class,
            'responseClass' => TagListingResponse::class,
            'condition' => [
                'method' => 'getBySlug',
                'args' => 'image',
                'return' => new Tag('Image', 'image'),
            ],
        ])];

        yield 'test_listing_category_listing_success' => [ListingTestDetails::create(new CategoryListingRequest('men'), [
            'listingClass' => CategoryListing::class,
            'gatewayClass' => CategoryGatewayInterface::class,
            'responseClass' => CategoryListingResponse::class,
            'condition' => [
                'method' => 'getBySlug',
                'args' => 'men',
                'return' => new Category('Men', 'men'),
            ],
        ])];
    }

    /**
     * @dataProvider dataFailedProvider
     *
     * @throws \Exception
     */
    public function testListingFailed(ListingTestDetails $details): void
    {
        $gateway = $this->createMock($details->getGatewayClass());

        if ($details->hasCondition()) {
            $gateway->method($details->getConditionMethod())
                ->with($details->getConditionArgs())
                ->willReturn($details->getConditionReturn())
            ;
        }

        $this->expectException($details->getExceptionClass());
        $this->expectExceptionMessage($details->getExceptionMessage());

        $this->useCase->execute($details->getRequest(), $details->getListing($gateway), $this->presenter);
    }

    public static function dataFailedProvider(): \Generator
    {
        yield 'test_listing_tag_listing_failed' => [ListingTestDetails::create(new TagListingRequest('image'), [
            'listingClass' => TagListing::class,
            'gatewayClass' => TagGatewayInterface::class,
            'responseClass' => TagListingResponse::class,
            'condition' => [
                'method' => 'getBySlug',
                'args' => 'image',
                'return' => null,
            ],
            'exception' => [
                'class' => TagNotFoundException::class,
                'message' => 'The Tag with slug image does not exist',
            ],
        ])];

        yield 'test_listing_category_listing_failed' => [ListingTestDetails::create(new CategoryListingRequest('men'), [
            'listingClass' => CategoryListing::class,
            'gatewayClass' => CategoryGatewayInterface::class,
            'responseClass' => CategoryListingResponse::class,
            'condition' => [
                'method' => 'getBySlug',
                'args' => 'men',
                'return' => null,
            ],
            'exception' => [
                'class' => CategoryNotFoundException::class,
                'message' => 'The Category with slug men does not exist',
            ],
        ])];

        yield 'test_listing_tag_with_wrong_request_failed' => [ListingTestDetails::create(new CategoryListingRequest('men'), [
            'listingClass' => TagListing::class,
            'gatewayClass' => TagGatewayInterface::class,
            'responseClass' => TagListingResponse::class,
            'exception' => [
                'class' => InvalidRequestException::class,
                'message' => 'Invalid Request Listing',
            ],
        ])];

        yield 'test_listing_category_with_wrong_request_failed' => [ListingTestDetails::create(new TagListingRequest('men'), [
            'listingClass' => CategoryListing::class,
            'gatewayClass' => CategoryGatewayInterface::class,
            'responseClass' => CategoryListingResponse::class,
            'exception' => [
                'class' => InvalidRequestException::class,
                'message' => 'Invalid Request Listing',
            ],
        ])];
    }
}
