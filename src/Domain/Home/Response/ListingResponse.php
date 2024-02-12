<?php

namespace App\Domain\Home\Response;

use Pagerfanta\Adapter\AdapterInterface;

readonly class ListingResponse
{
    public function __construct(private AdapterInterface $adapter, private int $currentPage, private int $maxPerPage)
    {
    }

    public function getAdapter(): AdapterInterface
    {
        return $this->adapter;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage ?: 1;
    }

    public function getMaxPerPage(): int
    {
        return $this->maxPerPage;
    }
}
