<?php

namespace App\Domain\Security\Gateway;

use App\Domain\Security\Entity\User;

interface UserGatewayInterface
{
    public function register(User $user): void;

    public function isExist(string $email): bool;
}
