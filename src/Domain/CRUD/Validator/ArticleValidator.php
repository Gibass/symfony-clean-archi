<?php

namespace App\Domain\CRUD\Validator;

use App\Domain\CRUD\Entity\CrudEntityInterface;
use Assert\Assertion;
use Assert\AssertionFailedException;

class ArticleValidator implements CrudEntityValidatorInterface
{
    /**
     * @throws AssertionFailedException
     */
    public function validate(CrudEntityInterface $entity): bool
    {
        Assertion::notBlank($entity->getTitle(), null, 'title');
        Assertion::minLength($entity->getTitle(), 25, null, 'title');
        Assertion::maxLength($entity->getTitle(), 255, null, 'title');

        return true;
    }
}
