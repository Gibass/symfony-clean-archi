<?php

namespace App\Domain\Security\Request;

readonly class UserVerifyRequest
{
    public function __construct(private string $token)
    {
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
