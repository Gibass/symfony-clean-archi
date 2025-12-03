<?php

namespace App\Core\Domain\Model\DTO;

interface DTOEntityInterface extends DTOInterface
{
    public function getPrimaryKey(): string;

    public function getPrimaryValue(): mixed;
}
