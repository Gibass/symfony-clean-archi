<?php

namespace App\Domain\Article\Gateway;

use App\Domain\Article\Entity\Article;
use App\Domain\Shared\Listing\Gateway\ListingGatewayInterface;

interface ArticleGatewayInterface extends ListingGatewayInterface
{
    public function getById(int $id): ?Article;

    public function getPublishedById(int $id): ?Article;
}
