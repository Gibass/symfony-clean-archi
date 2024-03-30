<?php

namespace App\Domain\Security\Gateway;

use App\Domain\Security\Entity\UserEntityInterface;

interface UserGatewayInterface
{
    public function register(array $data): UserEntityInterface;

    public function findByEmail(string $email): ?UserEntityInterface;

    public function validate(UserEntityInterface $user): void;
}
