<?php

namespace App\Domain\Tag\Response;

use App\Domain\Article\Entity\Tag;
use App\Domain\Shared\Response\AbstractListingResponse;
use Pagerfanta\Adapter\AdapterInterface;

class ListingResponse extends AbstractListingResponse
{
    private Tag $tag;

    public function __construct(AdapterInterface $adapter, Tag $tag, int $currentPage, int $maxPerPage)
    {
        parent::__construct($adapter, $currentPage, $maxPerPage);
        $this->tag = $tag;
    }

    public function getTag(): Tag
    {
        return $this->tag;
    }

    public function setTag(Tag $tag): ListingResponse
    {
        $this->tag = $tag;

        return $this;
    }
}
