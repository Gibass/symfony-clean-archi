<?php

namespace App\Domain\Tag\Request;

readonly class ListingRequest
{
    public function __construct(private string $slug, private int $page = 0)
    {
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getPage(): int
    {
        return $this->page;
    }
}
