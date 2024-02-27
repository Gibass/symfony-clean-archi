<?php

namespace App\Domain\Shared\Listing\Response;

use Pagerfanta\Adapter\AdapterInterface;

interface ListingResponseInterface
{
    public function getAdapter(): AdapterInterface;

    public function getCurrentPage(): int;

    public function getMaxPerPage(): int;
}
