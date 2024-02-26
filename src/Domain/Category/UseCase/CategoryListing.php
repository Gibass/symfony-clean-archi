<?php

namespace App\Domain\Category\UseCase;

use App\Domain\Article\Entity\Category;
use App\Domain\Category\Condition\ListingConditionRequest;
use App\Domain\Category\Gateway\CategoryGatewayInterface;
use App\Domain\Category\Request\ListingRequest;
use App\Domain\Category\Response\ListingResponse;
use App\Domain\Shared\Listing\Action\ListingInterface;
use App\Domain\Shared\Listing\Condition\ConditionRequestInterface;
use App\Domain\Shared\Listing\Exception\InvalidRequestException;
use App\Domain\Shared\Listing\Gateway\ListingGatewayInterface;
use App\Domain\Shared\Listing\Request\ListingRequestInterface;
use Pagerfanta\Adapter\AdapterInterface;

readonly class CategoryListing implements ListingInterface
{
    private ?Category $category;

    public function __construct(private CategoryGatewayInterface $gateway)
    {
    }

    /**
     * @throws InvalidRequestException
     */
    public function getRequestCondition(ListingRequestInterface $request): ConditionRequestInterface
    {
        if (!$request instanceof ListingRequest) {
            throw new InvalidRequestException('Invalid Request Listing');
        }

        $this->category = $this->gateway->getBySlug($request->getSlug());

        return new ListingConditionRequest($request, $this->category);
    }

    public function getListingGateway(): ListingGatewayInterface
    {
        return $this->gateway;
    }

    public function createResponse(AdapterInterface $adapter, ListingRequestInterface $request): ListingResponse
    {
        return new ListingResponse($adapter, $this->category, $request->getCurrentPage(), 10);
    }
}
