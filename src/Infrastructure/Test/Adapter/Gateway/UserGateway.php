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

    public function findByEmail(string $email): ?User
    {
        if ($email === 'used@mail.com') {
            return (new User())->setEmail($email);
        }

        return null;
    }

    public function validate(User $user): void
    {
        $user->setIsVerified(true);
    }
}
