<?php

namespace App\UserInterface\DTO;

use App\Domain\Security\Entity\UserEntityInterface;

class ArticleDTO extends EntityDTO
{
    private ?int $id = null;
    private ?string $title = null;
    private ?string $description = null;
    private ?string $content = null;
    private bool $status = false;
    private ?UserEntityInterface $owner = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): ArticleDTO
    {
        $this->id = $id;

        return $this;
    }

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

    public function getOwner(): ?UserEntityInterface
    {
        return $this->owner;
    }

    public function setOwner(?UserEntityInterface $owner): ArticleDTO
    {
        $this->owner = $owner;

        return $this;
    }
}
