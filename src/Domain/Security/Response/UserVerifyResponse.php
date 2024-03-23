<?php

namespace App\Domain\Security\Response;

class UserVerifyResponse
{
    public function __construct(private readonly string $token, private ?int $invalidCode = null)
    {
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getInvalidCode(): ?int
    {
        return $this->invalidCode;
    }

    public function setInvalidCode(?int $invalidCode): UserVerifyResponse
    {
        $this->invalidCode = $invalidCode;

        return $this;
    }
}
