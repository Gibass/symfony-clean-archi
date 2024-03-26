<?php

namespace App\Domain\Article\Gateway;

use App\Domain\Article\Entity\Article;
use App\Domain\CRUD\Gateway\CrudGatewayInterface;

interface ArticleGatewayInterface extends CrudGatewayInterface
{
    public function getPublishedById(int $id): ?Article;

    public function getLastArticles(): array;
}
