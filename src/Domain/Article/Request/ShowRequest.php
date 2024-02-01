<?php

namespace App\Domain\Article\Request;

readonly class ShowRequest
{
    public function __construct(private int $id)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
