<?php

namespace App\Domain\Security\Response;

use App\Domain\Security\Entity\UserEntityInterface;

readonly class UserSendValidateResponse
{
    public function __construct(private UserEntityInterface $user, private string $token)
    {
    }

    public function getUser(): UserEntityInterface
    {
        return $this->user;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
