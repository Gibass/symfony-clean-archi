<?php

namespace App\Domain\Article\Entity;

interface TaxonomyInterface
{
    public function getId(): ?int;

    public function setId(?int $id): static;

    public function getTitle(): ?string;

    public function setTitle(?string $title): static;

    public function getSlug(): ?string;
}
