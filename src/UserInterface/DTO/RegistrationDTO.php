<?php

namespace App\UserInterface\DTO;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationDTO
{
    #[NotBlank]
    #[Email]
    private ?string $email = null;

    #[NotBlank]
    #[Length(min: 6)]
    private ?string $plainPassword = null;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): RegistrationDTO
    {
        $this->email = $email;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): RegistrationDTO
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }
}
