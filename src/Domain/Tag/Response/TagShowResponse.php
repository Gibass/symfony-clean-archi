<?php

namespace App\Domain\Tag\Response;

use App\Domain\Article\Entity\Tag;
use App\Domain\Shared\Listing\Response\AbstractListingResponse;
use Pagerfanta\Adapter\AdapterInterface;

class TagShowResponse extends AbstractListingResponse
{
    public function __construct(
        AdapterInterface $adapter,
        private readonly Tag $tag,
        private readonly array $categories,
        private readonly array $tags,
        private readonly array $lastArticles,
        int $currentPage, int $maxPerPage
    ) {
        parent::__construct($adapter, $currentPage, $maxPerPage);
    }

    public function getTag(): Tag
    {
        return $this->tag;
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
