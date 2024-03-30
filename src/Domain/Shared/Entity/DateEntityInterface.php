<?php

namespace App\Domain\Shared\Entity;

interface DateEntityInterface
{
    public function getCreatedAt();

    public function setCreatedAt(\DateTime $createdAt);

    public function setUpdatedAt(\DateTime $updatedAt);
}
