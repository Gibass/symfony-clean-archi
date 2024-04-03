<?php

namespace App\Domain\CRUD\Entity;

readonly class PostedData
{
    public function __construct(private array $data)
    {
    }

    public function get(string $key)
    {
        return $this->data[$key] ?? null;
    }

    public function createEntity(string $class): CrudEntityInterface
    {
        $reflect = new \ReflectionClass($class);
        $entity = $reflect->newInstance();

        foreach ($reflect->getProperties() as $property) {
            $name = $property->getName();
            $setter = 'set' . ucfirst($name);

            if ($reflect->hasMethod($setter) && !empty($this->data[$name])) {
                $entity->{$setter}($this->data[$name]);
            }
        }

        return $entity;
    }

    public function updateEntity(CrudEntityInterface $entity): CrudEntityInterface
    {
        foreach ($this->data as $key => $value) {
            $setter = 'set' . ucfirst($key);
            if (method_exists($entity, $setter)) {
                $entity->{$setter}($value);
            }
        }

        return $entity;
    }
}
