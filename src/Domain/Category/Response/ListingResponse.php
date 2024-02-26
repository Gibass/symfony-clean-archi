<?php

namespace App\Domain\Category\Response;

use App\Domain\Article\Entity\Category;
use App\Domain\Shared\Listing\Response\AbstractListingResponse;
use Pagerfanta\Adapter\AdapterInterface;

class ListingResponse extends AbstractListingResponse
{
    public function __construct(AdapterInterface $adapter, private readonly Category $category, int $currentPage, int $maxPerPage)
    {
        parent::__construct($adapter, $currentPage, $maxPerPage);
    }

    public function getCategory(): Category
    {
        return $this->category;
    }
}
