<?php

namespace App\Domain\Article\Gateway;

use App\Domain\Article\Entity\ArticleInterface;
use App\Domain\CRUD\Gateway\CrudGatewayInterface;

interface ArticleGatewayInterface extends CrudGatewayInterface
{
    public function getPublishedById(int $id): ?ArticleInterface;

    public function getLastArticles(): array;

    public function getById(int $id): ?ArticleInterface;
}
