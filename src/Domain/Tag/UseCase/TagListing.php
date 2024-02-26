<?php

namespace App\Domain\Tag\UseCase;

use App\Domain\Article\Entity\Tag;
use App\Domain\Shared\Listing\Action\ListingInterface;
use App\Domain\Shared\Listing\Condition\ConditionRequestInterface;
use App\Domain\Shared\Listing\Exception\InvalidRequestException;
use App\Domain\Shared\Listing\Gateway\ListingGatewayInterface;
use App\Domain\Shared\Listing\Request\ListingRequestInterface;
use App\Domain\Tag\Condition\ListingConditionRequest;
use App\Domain\Tag\Gateway\TagGatewayInterface;
use App\Domain\Tag\Request\ListingRequest;
use App\Domain\Tag\Response\ListingResponse;
use Pagerfanta\Adapter\AdapterInterface;

readonly class TagListing implements ListingInterface
{
    private ?Tag $tag;

    public function __construct(private TagGatewayInterface $tagGateway)
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

        $this->tag = $this->tagGateway->getBySlug($request->getSlug());

        return new ListingConditionRequest($request, $this->tag);
    }

    public function getListingGateway(): ListingGatewayInterface
    {
        return $this->tagGateway;
    }

    public function createResponse(AdapterInterface $adapter, ListingRequestInterface $request): ListingResponse
    {
        return new ListingResponse($adapter, $this->tag, $request->getCurrentPage(), 10);
    }
}
