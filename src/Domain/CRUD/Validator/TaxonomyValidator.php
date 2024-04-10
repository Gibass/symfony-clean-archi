<?php

namespace App\Domain\CRUD\Validator;

use App\Domain\CRUD\Entity\CrudEntityInterface;
use Assert\Assertion;

class TaxonomyValidator implements CrudEntityValidatorInterface
{
    public function validate(CrudEntityInterface $entity): bool
    {
        Assertion::notBlank($entity->getTitle(), null, 'title');
        Assertion::maxLength($entity->getTitle(), 128, null, 'title');

        return true;
    }
}
