<?php

namespace App\Domain\Security\Request;

use App\Domain\Security\Entity\User;

readonly class UserValidateRequest
{
    public function __construct(private User $user)
    {
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
