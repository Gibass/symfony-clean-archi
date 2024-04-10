<?php

namespace App\Domain\CRUD\Response;

use App\Domain\Shared\Listing\Response\AbstractListingResponse;
use Pagerfanta\Adapter\AdapterInterface;

class ListingResponse extends AbstractListingResponse
{
    public function __construct(
        private readonly array $routes,
        AdapterInterface $adapter,
        int $currentPage,
        int $maxPerPage,
    ) {
        parent::__construct($adapter, $currentPage, $maxPerPage);
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}
