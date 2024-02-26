<?php

namespace App\Domain\Tag\Response;

use App\Domain\Article\Entity\Tag;
use App\Domain\Shared\Listing\Response\AbstractListingResponse;
use Pagerfanta\Adapter\AdapterInterface;

class ListingResponse extends AbstractListingResponse
{
    public function __construct(AdapterInterface $adapter, private readonly Tag $tag, int $currentPage, int $maxPerPage)
    {
        parent::__construct($adapter, $currentPage, $maxPerPage);
    }

    public function getTag(): Tag
    {
        return $this->tag;
    }
}
