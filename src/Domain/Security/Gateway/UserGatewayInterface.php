<?php

namespace App\Domain\Security\Gateway;

use App\Domain\CRUD\Gateway\CrudGatewayInterface;
use App\Domain\Security\Entity\UserEntityInterface;

interface UserGatewayInterface extends CrudGatewayInterface
{
    public function register(array $data): UserEntityInterface;

    public function findByEmail(string $email): ?UserEntityInterface;

    public function validate(UserEntityInterface $user): void;
}
