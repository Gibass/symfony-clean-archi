<?php

namespace App\Domain\Security\Request;

use App\Domain\Security\Entity\UserEntityInterface;

readonly class UserSendValidateRequest
{
    public function __construct(private UserEntityInterface $user)
    {
    }

    public function getUser(): UserEntityInterface
    {
        return $this->user;
    }
}
