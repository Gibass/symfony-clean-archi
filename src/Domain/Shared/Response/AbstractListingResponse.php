<?php

namespace App\Domain\Shared\Response;

use Pagerfanta\Adapter\AdapterInterface;

abstract class AbstractListingResponse
{
    public function __construct(
        private readonly AdapterInterface $adapter,
        private readonly int $currentPage,
        private readonly int $maxPerPage
    ) {
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
