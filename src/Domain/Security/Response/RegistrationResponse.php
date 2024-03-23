<?php

namespace App\Domain\Security\Response;

use App\Domain\Security\Entity\User;

readonly class RegistrationResponse
{
    public function __construct(private User $user)
    {
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
