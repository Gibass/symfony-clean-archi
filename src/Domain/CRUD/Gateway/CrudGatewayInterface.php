<?php

namespace App\Domain\CRUD\Gateway;

use App\Domain\CRUD\Entity\CrudEntityInterface;
use App\Domain\CRUD\Entity\PostedData;
use App\Domain\Shared\Listing\Gateway\ListingGatewayInterface;

interface CrudGatewayInterface extends ListingGatewayInterface
{
    public function create(PostedData $data): CrudEntityInterface;
}
