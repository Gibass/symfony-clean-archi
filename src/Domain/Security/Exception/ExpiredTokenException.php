<?php

namespace App\Domain\Security\Exception;

class ExpiredTokenException extends \Exception
{
    public const INVALID_CODE = 1002;

    public function getInvalidCode(): int
    {
        return self::INVALID_CODE;
    }
}
