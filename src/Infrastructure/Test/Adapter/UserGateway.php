<?php

namespace App\Infrastructure\Test\Adapter;

use App\Domain\Security\Entity\User;
use App\Domain\Security\Gateway\UserGatewayInterface;

class UserGateway implements UserGatewayInterface
{
    public function register(User $user): void
    {
        // TODO: Implement register() method.
    }

    public function isExist(string $email): bool
    {
        return $email === 'used@mail.com';
    }
}
