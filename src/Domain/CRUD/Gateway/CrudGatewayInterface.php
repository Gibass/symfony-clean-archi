<?php

namespace App\Domain\CRUD\Gateway;

use App\Domain\CRUD\Entity\CrudEntityInterface;
use App\Domain\CRUD\Entity\PostedData;
use App\Domain\Shared\Listing\Gateway\ListingGatewayInterface;

interface CrudGatewayInterface extends ListingGatewayInterface
{
    public function getByIdentifier(string|int $identifier): ?CrudEntityInterface;

    public function create(PostedData $data): CrudEntityInterface;

    public function update(PostedData $data): CrudEntityInterface;

    public function delete(CrudEntityInterface $entity): bool;
}
