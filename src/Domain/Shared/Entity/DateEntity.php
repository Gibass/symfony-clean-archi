<?php

namespace App\Domain\Shared\Entity;

trait DateEntity
{
    private ?\DateTime $createdAt = null;
    private ?\DateTime $updateAt = null;

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function setUpdatedAt(?\DateTime $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }
}
