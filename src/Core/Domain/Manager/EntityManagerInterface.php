<?php

namespace App\Core\Domain\Manager;

interface EntityManagerInterface
{
    public function save($entity): void;

    public function flush(): void;

    public function remove($entity): void;

    public function getRepository(string $className);
}
