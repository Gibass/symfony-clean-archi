<?php

namespace App\Domain\CRUD\Request;

use App\Domain\CRUD\Entity\CrudEntityInterface;

readonly class UpdateRequest
{
    public function __construct(private CrudEntityInterface $entity)
    {
    }

    public function getEntity(): CrudEntityInterface
    {
        return $this->entity;
    }
}
