<?php

namespace App\Domain\Shared\Listing\Request;

abstract class AbstractListingRequest implements ListingRequestInterface
{
    public function __construct(private readonly int $page = 0)
    {
    }

    public function getCurrentPage(): int
    {
        return $this->page;
    }
}
