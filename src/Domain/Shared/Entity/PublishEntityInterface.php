<?php

namespace App\Domain\Shared\Entity;

interface PublishEntityInterface
{
    public function isPublished(): ?bool;

    public function setStatus(bool $status): self;

    public function getPublishedAt(): ?\DateTimeImmutable;

    public function setPublishedAt(?\DateTimeImmutable $publishedAt): self;
}
