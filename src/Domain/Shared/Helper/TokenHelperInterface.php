<?php

namespace App\Domain\Shared\Helper;

use App\Domain\Security\Entity\UserEntityInterface;
use App\Domain\Security\Exception\ExpiredTokenException;
use App\Domain\Security\Exception\InvalidTokenException;

interface TokenHelperInterface
{
    public function generateUserToken(UserEntityInterface $user, int $lifetime = 3600): string;

    /**
     * @throws InvalidTokenException
     * @throws ExpiredTokenException
     */
    public function verifyToken(string $token): array;
}
