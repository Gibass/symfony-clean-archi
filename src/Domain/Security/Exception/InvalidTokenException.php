<?php

namespace App\Domain\Security\Exception;

class InvalidTokenException extends \Exception
{
    public const INVALID_CODE = 1001;

    public function getInvalidCode(): int
    {
        return self::INVALID_CODE;
    }
}
