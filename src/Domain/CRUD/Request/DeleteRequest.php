<?php

namespace App\Domain\CRUD\Request;

readonly class DeleteRequest
{
    public function __construct(private string|int $identifier)
    {
    }

    public function getIdentifier(): string|int
    {
        return $this->identifier;
    }
}
