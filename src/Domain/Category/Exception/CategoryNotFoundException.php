<?php

namespace App\Domain\Category\Exception;

class CategoryNotFoundException extends \Exception
{
    public function __construct(string $field, string $value)
    {
        parent::__construct(sprintf('The Category with %s %s does not exist', $field, $value));
    }
}
