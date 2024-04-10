<?php

namespace App\Domain\CRUD\Request;

use App\Domain\CRUD\Entity\CrudEntityInterface;

readonly class CreateRequest
{
    public function __construct(private CrudEntityInterface $entity)
    {
    }

    public function getEntity(): CrudEntityInterface
    {
        return $this->entity;
    }
}
