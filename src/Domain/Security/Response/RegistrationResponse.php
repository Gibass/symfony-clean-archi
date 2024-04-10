<?php

namespace App\Domain\Security\Response;

use App\Domain\Security\Entity\UserEntityInterface;

readonly class RegistrationResponse
{
    public function __construct(private UserEntityInterface $user)
    {
    }

    public function getUser(): UserEntityInterface
    {
        return $this->user;
    }
}
