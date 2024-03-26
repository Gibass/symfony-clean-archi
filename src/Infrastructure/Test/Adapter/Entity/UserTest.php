<?php

namespace App\Infrastructure\Test\Adapter\Entity;

use App\Domain\Security\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

class UserTest extends User implements UserInterface
{
    public function getRoles(): array
    {
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->getEmail();
    }
}
