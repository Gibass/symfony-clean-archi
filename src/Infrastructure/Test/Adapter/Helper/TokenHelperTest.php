<?php

namespace App\Infrastructure\Test\Adapter\Helper;

use App\Domain\Security\Entity\User;
use App\Domain\Security\Exception\ExpiredTokenException;
use App\Domain\Security\Exception\InvalidTokenException;
use App\Domain\Shared\Helper\TokenHelperInterface;

class TokenHelperTest implements TokenHelperInterface
{
    public function generateUserToken(User $user, int $lifetime = 3600): string
    {
        return 'token';
    }

    public function verifyToken(string $token): array
    {
        if ($token === 'invalid-token') {
            throw new InvalidTokenException();
        }

        if ($token === 'expired-token') {
            throw new ExpiredTokenException();
        }

        if ($token === 'not-found-token') {
            return [
                'user_email' => 'not-found@mail.com',
            ];
        }

        return [
            'user_email' => 'used@mail.com',
        ];
    }
}
