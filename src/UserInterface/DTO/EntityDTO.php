<?php

namespace App\UserInterface\DTO;

abstract class EntityDTO
{
    public function toArray(): array
    {
        $data = [];
        $reflect = new \ReflectionClass($this);

        foreach ($reflect->getProperties() as $property) {
            $data[$property->getName()] = $property->getValue($this);
        }

        return $data;
    }
}
