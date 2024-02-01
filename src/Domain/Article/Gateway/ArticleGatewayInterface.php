<?php

namespace App\Domain\Article\Gateway;

use App\Domain\Article\Entity\Article;

interface ArticleGatewayInterface
{
    public function getById(int $id): ?Article;
}