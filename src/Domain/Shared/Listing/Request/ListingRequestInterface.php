<?php

namespace App\Domain\Shared\Listing\Request;

interface ListingRequestInterface
{
    public function getCurrentPage(): int;
}
