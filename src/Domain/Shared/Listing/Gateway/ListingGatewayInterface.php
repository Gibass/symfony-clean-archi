<?php

namespace App\Domain\Shared\Listing\Gateway;

use Pagerfanta\Adapter\AdapterInterface;

interface ListingGatewayInterface
{
    public function getPaginatedAdapter(array $conditions = []): AdapterInterface;
}
