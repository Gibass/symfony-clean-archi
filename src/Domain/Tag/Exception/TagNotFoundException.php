<?php

namespace App\Domain\Tag\Exception;

class TagNotFoundException extends \Exception
{
    public function __construct(string $field, string $value)
    {
        parent::__construct(sprintf('The Tag with %s %s does not exist', $field, $value));
    }
}
