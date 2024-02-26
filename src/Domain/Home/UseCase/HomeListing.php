<?php

namespace App\Domain\Home\UseCase;

use App\Domain\Article\Gateway\ArticleGatewayInterface;
use App\Domain\Home\Condition\ListingConditionRequest;
use App\Domain\Home\Response\ListingResponse;
use App\Domain\Shared\Listing\Action\ListingInterface;
use App\Domain\Shared\Listing\Condition\ConditionRequestInterface;
use App\Domain\Shared\Listing\Gateway\ListingGatewayInterface;
use App\Domain\Shared\Listing\Request\ListingRequestInterface;
use Pagerfanta\Adapter\AdapterInterface;

readonly class HomeListing implements ListingInterface
{
    public function __construct(private ArticleGatewayInterface $articleGateway)
    {
    }

    public function getRequestCondition(ListingRequestInterface $request): ConditionRequestInterface
    {
        return new ListingConditionRequest();
    }

    public function getListingGateway(): ListingGatewayInterface
    {
        return $this->articleGateway;
    }

    public function createResponse(AdapterInterface $adapter, ListingRequestInterface $request): ListingResponse
    {
        return new ListingResponse($adapter, $request->getCurrentPage(), 10);
    }
}
