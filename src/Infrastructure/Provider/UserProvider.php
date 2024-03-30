<?php

namespace App\Infrastructure\Provider;

use App\Domain\Security\Gateway\UserGatewayInterface;
use App\Infrastructure\Doctrine\Entity\User;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
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

    public function supportsClass(string $class): bool
    {
        return $class === User::class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->gateway->findByEmail($identifier);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
