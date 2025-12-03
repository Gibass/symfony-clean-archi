<?php

namespace App\Core\Domain\Manager;

use App\Core\Domain\Model\DTO\DTOInterface;

interface DTOManagerInterface
{
    public function transform(?DTOInterface $value, array $context = []): mixed;

    public function createFrom(string $dtoClass, mixed $value,  array $context = []): DTOInterface;
}
