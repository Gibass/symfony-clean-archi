<?php

namespace App\Infrastructure\Test\Adapter\Gateway;

use App\Domain\Security\Entity\User;
use App\Domain\Security\Gateway\UserGatewayInterface;

class UserGateway implements UserGatewayInterface
{
    public function register(User $user): User
    {
        return new User();
    }

    public function isExist(string $email): bool
    {
        return $email === 'used@mail.com';
    }
}
