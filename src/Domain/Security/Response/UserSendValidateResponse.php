<?php

namespace App\Domain\Security\Response;

use App\Domain\Security\Entity\User;

readonly class UserSendValidateResponse
{
    public function __construct(private User $user, private string $token)
    {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
