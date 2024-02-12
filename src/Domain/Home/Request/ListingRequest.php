<?php

namespace App\Domain\Home\Request;

readonly class ListingRequest
{
    public function __construct(private int $page = 0)
    {
    }

    public function getPage(): int
    {
        return $this->page;
    }
}
