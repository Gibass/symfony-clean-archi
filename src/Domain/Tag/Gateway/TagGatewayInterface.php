<?php

namespace App\Domain\Tag\Gateway;

use App\Domain\Article\Entity\Tag;
use App\Domain\Shared\Listing\Gateway\ListingGatewayInterface;

interface TagGatewayInterface extends ListingGatewayInterface
{
    public function getBySlug(string $slug): ?Tag;

    public function getPopularTag(): array;
}
