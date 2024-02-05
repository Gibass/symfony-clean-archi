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
    private ?string $content = null;

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
