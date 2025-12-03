<?php

namespace App\Article\Domain\Gateway;

use App\Article\Domain\Model\Entity\Article;

interface ArticleGatewayInterface
{
    public function getAll(): array;
}
