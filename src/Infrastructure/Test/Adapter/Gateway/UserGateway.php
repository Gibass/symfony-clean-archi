<?php

namespace App\Infrastructure\Test\Adapter\Gateway;

use App\Domain\Security\Entity\UserEntityInterface;
use App\Domain\Security\Gateway\UserGatewayInterface;
use App\Infrastructure\Doctrine\Entity\User;

class UserGateway implements UserGatewayInterface
{
    public function register(array $data): UserEntityInterface
    {
        return (new User())
            ->setEmail($data['email'] ?? null)
            ->setPassword($data['password'] ?? null)
        ;
    }

    public function findByEmail(string $email): ?User
    {
        if ($email === 'used@mail.com') {
            return (new User())->setEmail($email);
        }

        if ($email === 'test@test.com') {
            return (new User())->setEmail($email)
                ->setIsVerified(true)
                ->setPassword('password')
            ;
        }

        return null;
    }

    public function validate(UserEntityInterface $user): void
    {
        $user->setIsVerified(true);
    }
}
