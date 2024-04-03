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

    public static function create(object $entity): static
    {
        $reflect = new \ReflectionClass(static::class);
        $instance = $reflect->newInstance();

        foreach ($reflect->getProperties() as $property) {
            $setter = 'set' . ucfirst($property->getName());
            $getter = 'get' . ucfirst($property->getName());
            if ($reflect->hasMethod($setter) && method_exists($entity, $getter)) {
                $instance->{$setter}($entity->{$getter}());
            }
        }

        return $instance;
    }
}
