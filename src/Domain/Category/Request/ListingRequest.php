<?php

namespace App\Domain\Category\Request;

use App\Domain\Shared\Listing\Request\AbstractListingRequest;

class ListingRequest extends AbstractListingRequest
{
    public function __construct(private readonly string $slug, int $page = 0)
    {
        parent::__construct($page);
    }

    public function getSLug(): string
    {
        return $this->slug;
    }
}
