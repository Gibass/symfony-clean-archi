<?php

namespace App\Domain\CRUD\Entity;

interface CrudEntityInterface
{
    public function getIdentifier(): mixed;
}
