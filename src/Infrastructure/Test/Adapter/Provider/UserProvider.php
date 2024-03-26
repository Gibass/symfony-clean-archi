<?php

namespace App\Infrastructure\Test\Adapter\Provider;

use App\Domain\Security\Gateway\UserGatewayInterface;
use App\Infrastructure\Test\Adapter\Entity\UserTest;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

readonly class UserProvider implements UserProviderInterface
{
    public function __construct(private UserGatewayInterface $gateway)
    {
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->gateway->findByEmail($user->getUserIdentifier());
    }

    public function supportsClass(string $class)
    {
        return $class === UserTest::class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        return $this->gateway->findByEmail($identifier);
    }
}
