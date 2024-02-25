<?php

namespace App\Domain\Article\Entity;

class Tag extends Taxonomy
{
    public function __construct(protected ?string $title, protected ?string $slug)
    {
    }
}
