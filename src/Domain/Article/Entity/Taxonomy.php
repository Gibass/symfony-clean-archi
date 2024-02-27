<?php

namespace App\Domain\Article\Entity;

abstract class Taxonomy
{
    protected ?int $id = null;

    public function __construct(protected ?string $title, protected ?string $slug)
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }
}
