<?php

namespace App\Domain\Tag\Gateway;

use App\Domain\Article\Entity\TagInterface;
use App\Domain\Article\Entity\TaxonomyInterface;
use App\Domain\Shared\Listing\Gateway\ListingGatewayInterface;

interface TagGatewayInterface extends ListingGatewayInterface
{
    public function getBySlug(string $slug): ?TaxonomyInterface;

    public function getPopularTag(): array;
}
