<?php

namespace App\Domain\Article\Gateway;

use App\Domain\Article\Entity\Article;
use Pagerfanta\Adapter\AdapterInterface;

interface ArticleGatewayInterface
{
    public function getById(int $id): ?Article;

    public function getPublishedById(int $id): ?Article;

    public function getPaginatedAdapter(): AdapterInterface;
}
