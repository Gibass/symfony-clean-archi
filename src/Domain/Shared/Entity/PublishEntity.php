<?php

namespace App\Domain\Shared\Entity;

trait PublishEntity
{
    private bool $status = false;

    private ?\DateTimeImmutable $publishedAt = null;

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeImmutable $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }
}
