<?php

namespace App\Infrastructure\Test\Adapter\Helper;

use App\Domain\Security\Entity\User;
use App\Domain\Security\Exception\ExpiredTokenException;
use App\Domain\Security\Exception\InvalidTokenException;
use App\Domain\Shared\Helper\TokenHelperInterface;

class TokenHelperTest implements TokenHelperInterface
{
    public function generateUserToken(User $user): string
    {
        return '';
    }

    public function verifyToken(string $token): bool
    {
        if ($token === 'invalid-token') {
            throw new InvalidTokenException();
        }

        if ($token === 'expired-token') {
            throw new ExpiredTokenException();
        }

        return true;
    }
}
