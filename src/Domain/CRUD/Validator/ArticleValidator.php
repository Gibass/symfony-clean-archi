<?php

namespace App\Domain\CRUD\Validator;

use App\Domain\CRUD\Entity\PostedData;
use Assert\Assertion;
use Assert\AssertionFailedException;

class ArticleValidator implements CrudEntityValidatorInterface
{
    /**
     * @throws AssertionFailedException
     */
    public function validate(PostedData $postedData): bool
    {
        Assertion::notBlank($postedData->get('title'), null, 'title');
        Assertion::minLength($postedData->get('title'), 25, null, 'title');
        Assertion::maxLength($postedData->get('title'), 255, null, 'title');

        return true;
    }
}
