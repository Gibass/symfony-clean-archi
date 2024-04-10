<?php

namespace App\Domain\CRUD\Validator;

use App\Domain\CRUD\Entity\CrudEntityInterface;
use App\Domain\CRUD\Exception\InvalidCrudEntityException;
use App\Domain\Security\Entity\UserEntityInterface;
use Assert\Assertion;
use Assert\AssertionFailedException;

class UserValidator implements CrudEntityValidatorInterface
{
    /**
     * @throws AssertionFailedException
     * @throws InvalidCrudEntityException
     */
    public function validate(CrudEntityInterface $entity): bool
    {
        if (!$entity instanceof UserEntityInterface) {
            throw new InvalidCrudEntityException();
        }

        Assertion::notBlank($entity->getEmail(), null, 'email');
        Assertion::email($entity->getEmail(), null, 'email');

        Assertion::notBlank($entity->getFirstname(), null, 'firstname');
        Assertion::notBlank($entity->getLastname(), null, 'lastname');

        return true;
    }
}
