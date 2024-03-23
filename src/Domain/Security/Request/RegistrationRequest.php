<?php

namespace App\Domain\Security\Request;

readonly class RegistrationRequest
{
    public function __construct(private string $email, private string $password, private string $confirmPassword)
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getConfirmPassword(): string
    {
        return $this->confirmPassword;
    }
}
