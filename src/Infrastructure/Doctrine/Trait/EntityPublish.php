<?php

namespace App\Infrastructure\Doctrine\Trait;

use App\Domain\Shared\Entity\PublishEntityInterface;
use Doctrine\ORM\Mapping as ORM;

trait EntityPublish
{
    #[ORM\Column]
    private bool $status = false;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $publishedAt = null;

    public function isPublished(): ?bool
    {
        return $this->status;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): PublishEntityInterface
    {
        $this->status = $status;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeImmutable $publishedAt): PublishEntityInterface
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }
}
