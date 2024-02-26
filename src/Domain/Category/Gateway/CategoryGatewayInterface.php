<?php

namespace App\Domain\Category\Gateway;

use App\Domain\Article\Entity\Category;
use App\Domain\Shared\Listing\Gateway\ListingGatewayInterface;

interface CategoryGatewayInterface extends ListingGatewayInterface
{
    public function getBySlug(string $slug): ?Category;
}
