<?php

namespace App\Domain\CRUD\Request;

use App\Domain\Shared\Listing\Request\AbstractListingRequest;

class ListingRequest extends AbstractListingRequest
{
    public function __construct(private readonly array $routes, int $page = 0)
    {
        parent::__construct($page);
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}
