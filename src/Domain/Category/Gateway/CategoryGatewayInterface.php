<?php

namespace App\Domain\Category\Gateway;

use App\Domain\Article\Entity\CategoryInterface;
use App\Domain\Article\Entity\TaxonomyInterface;
use App\Domain\Shared\Listing\Gateway\ListingGatewayInterface;

interface CategoryGatewayInterface extends ListingGatewayInterface
{
    public function getBySlug(string $slug): ?TaxonomyInterface;

    public function getFacetCategories(): array;
}
