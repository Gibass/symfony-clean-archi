<?php

namespace App\Infrastructure\Adapter\Repository\Trait;

use App\Domain\CRUD\Entity\CrudEntityInterface;

trait CrudRepository
{
    public function create(CrudEntityInterface $entity): CrudEntityInterface
    {
        $this->_em->persist($entity);
        $this->_em->flush();

        return $entity;
    }

    public function update(CrudEntityInterface $entity): CrudEntityInterface
    {
        $this->_em->flush();

        return $entity;
    }

    public function delete(CrudEntityInterface $entity): bool
    {
        $this->_em->remove($entity);

        $this->_em->flush();

        return true;
    }
}
