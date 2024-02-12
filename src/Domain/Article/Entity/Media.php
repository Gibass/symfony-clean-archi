<?php

namespace App\Domain\Article\Entity;

use App\Domain\Shared\Entity\DateEntity;

abstract class Media
{
    use DateEntity;

    private ?int $id = null;
    private ?string $title = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): Image
    {
        $this->title = $title;

        return $this;
    }
}
