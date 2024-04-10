<?php

namespace App\Domain\CRUD\Validator;

use App\Domain\CRUD\Entity\CrudEntityInterface;
use App\Domain\CRUD\Exception\InvalidCrudEntityException;
use Assert\AssertionFailedException;

interface CrudEntityValidatorInterface
{
    /**
     * @throws AssertionFailedException
     * @throws InvalidCrudEntityException
     */
    public function validate(CrudEntityInterface $entity): bool;
}
