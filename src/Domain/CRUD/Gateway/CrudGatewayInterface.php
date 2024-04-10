<?php

namespace App\Domain\CRUD\Gateway;

use App\Domain\CRUD\Entity\CrudEntityInterface;
use App\Domain\Shared\Listing\Gateway\ListingGatewayInterface;

interface CrudGatewayInterface extends ListingGatewayInterface
{
    public function getByIdentifier(string|int $identifier): ?CrudEntityInterface;

    public function create(CrudEntityInterface $entity): CrudEntityInterface;

    public function update(CrudEntityInterface $entity): CrudEntityInterface;

    public function delete(CrudEntityInterface $entity): bool;
}
