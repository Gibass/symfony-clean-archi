<?php

namespace App\Domain\Security\Gateway;

use App\Domain\Security\Entity\User;

interface UserGatewayInterface
{
    public function register(User $user): User;

    public function findByEmail(string $email): ?User;

    public function validate(User $user): void;
}
