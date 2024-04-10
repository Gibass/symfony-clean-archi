<?php

namespace App\Domain\Category\Response;

use App\Domain\Article\Entity\ArticleInterface;
use App\Domain\Article\Entity\TaxonomyInterface;
use App\Domain\Shared\Listing\Response\AbstractListingResponse;
use Pagerfanta\Adapter\AdapterInterface;

class CategoryShowResponse extends AbstractListingResponse
{
    public function __construct(
        AdapterInterface $adapter,
        private readonly TaxonomyInterface $category,
        private readonly array $categories,
        private readonly array $tags,
        private readonly array $lastArticles,
        int $currentPage, int $maxPerPage
    ) {
        parent::__construct($adapter, $currentPage, $maxPerPage);
    }

    public function getCategory(): TaxonomyInterface
    {
        return $this->category;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @return ArticleInterface[]
     */
    public function getLastArticles(): array
    {
        return $this->lastArticles;
    }
}
