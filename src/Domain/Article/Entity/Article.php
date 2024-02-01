<?php

namespace App\Domain\Article\Entity;

class Article
{
    public ?int $id = null;

    public ?string $slug = null;

    public ?string $title = null;

    public ?string $content = null;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): Article
    {
        $this->content = $content;
        return $this;
    }
}