<?php

namespace App\Domain\Article\Entity;

use App\Domain\Shared\Entity\DateEntity;
use App\Domain\Shared\Entity\PublishEntity;

class Article
{
    use DateEntity;
    use PublishEntity;

    private ?int $id = null;
    private ?string $slug = null;
    private ?string $title = null;
    private ?Media $mainMedia = null;
    private ?string $description = null;
    private ?string $content = null;
    private ?Category $category = null;

    /**
     * @var Tag[]
     */
    private array $tags = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Article
    {
        $this->id = $id;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): Article
    {
        $this->slug = $slug;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): Article
    {
        $this->title = $title;

        return $this;
    }

    public function getMainMedia(): ?Media
    {
        return $this->mainMedia;
    }

    public function setMainMedia(?Media $mainMedia): Article
    {
        $this->mainMedia = $mainMedia;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Article
    {
        $this->description = $description;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): Article
    {
        $this->content = $content;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Tag[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param Tag[] $tags
     */
    public function addTags(array $tags): Article
    {
        foreach ($tags as $tag) {
            $this->tags[] = $tag;
        }

        return $this;
    }
}
