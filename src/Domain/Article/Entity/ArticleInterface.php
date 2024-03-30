<?php

namespace App\Domain\Article\Entity;

use App\Domain\CRUD\Entity\CrudEntityInterface;
use App\Domain\Shared\Entity\DateEntityInterface;
use App\Domain\Shared\Entity\PublishEntityInterface;

interface ArticleInterface
{
    public function getId(): ?int;

    public function setId(?int $id): ArticleInterface;

    public function getSlug(): ?string;

    public function setSlug(?string $slug): ArticleInterface;

    public function getTitle(): ?string;

    public function setTitle(?string $title): ArticleInterface;

    public function getDescription(): ?string;

    public function setDescription(?string $description): ArticleInterface;

    public function getContent(): ?string;

    public function setContent(?string $content): ArticleInterface;

    public function getCategory(): ?TaxonomyInterface;

    public function setCategory(?TaxonomyInterface $category): static;

    /**
     * @return TaxonomyInterface[]
     */
    public function getTags(): mixed;

    /**
     * @param TaxonomyInterface[] $tags
     */
    public function addTags(array $tags): ArticleInterface;
}
