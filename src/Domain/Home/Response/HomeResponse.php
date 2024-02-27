<?php

namespace App\Domain\Home\Response;

use App\Domain\Shared\Listing\Response\AbstractListingResponse;
use Pagerfanta\Adapter\AdapterInterface;

class HomeResponse extends AbstractListingResponse
{
    public function __construct(
        AdapterInterface $adapter,
        private readonly array $categories,
        private readonly array $tags,
        private readonly array $lastArticles,
        int $currentPage,
        int $maxPerPage
    ) {
        parent::__construct($adapter, $currentPage, $maxPerPage);
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function getLastArticles(): array
    {
        return $this->lastArticles;
    }
}
