<?php

namespace App\Domain\Shared\Listing\Action;

use App\Domain\Shared\Listing\Gateway\ListingGatewayInterface;
use App\Domain\Shared\Listing\Request\ListingRequestInterface;
use Pagerfanta\Adapter\AdapterInterface;

interface ListingInterface
{
    public function getListingGateway(): ListingGatewayInterface;

    public function createResponse(AdapterInterface $adapter, ListingRequestInterface $request): mixed;
}
