<?php

namespace App\Domain\CRUD\Validator;

use App\Domain\CRUD\Entity\PostedData;
use Assert\AssertionFailedException;

interface CrudEntityValidatorInterface
{
    /**
     * @throws AssertionFailedException
     */
    public function validate(PostedData $postedData): bool;
}
