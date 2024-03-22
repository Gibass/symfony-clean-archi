<?php

namespace App\Domain\Shared\Helper;

use App\Domain\Security\Entity\User;
use App\Domain\Security\Exception\ExpiredTokenException;
use App\Domain\Security\Exception\InvalidTokenException;

interface TokenHelperInterface
{
    public function generateUserToken(User $user): string;

    /**
     * @throws InvalidTokenException
     * @throws ExpiredTokenException
     */
    public function verifyToken(string $token): bool;
}
