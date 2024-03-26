<?php

namespace App\UserInterface\DTO;

class ArticleDTO extends EntityDTO
{
    private ?string $title = null;
    private ?string $description = null;
    private ?string $content = null;
    private bool $status = false;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): ArticleDTO
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): ArticleDTO
    {
        $this->description = $description;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): ArticleDTO
    {
        $this->content = $content;

        return $this;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): ArticleDTO
    {
        $this->status = $status;

        return $this;
    }
}
