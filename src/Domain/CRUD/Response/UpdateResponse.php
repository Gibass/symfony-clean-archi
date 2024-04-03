<?php

namespace App\Domain\CRUD\Response;

use App\Domain\CRUD\Entity\CrudEntityInterface;

readonly class UpdateResponse
{
    public function __construct(private CrudEntityInterface $entity)
    {
    }

    public function getEntity(): CrudEntityInterface
    {
        return $this->entity;
    }
}
