<?php

namespace App\Domain\Security\Exception;

class EmailNotFoundException extends \Exception
{
    public const INVALID_CODE = 1003;

    public function getInvalidCode(): int
    {
        return self::INVALID_CODE;
    }
}
