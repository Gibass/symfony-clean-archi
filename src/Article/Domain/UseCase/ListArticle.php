<?php

namespace App\Article\Domain\UseCase;

use App\Article\Domain\Gateway\ArticleGatewayInterface;

readonly class ListArticle
{
    public function __construct(private ArticleGatewayInterface $articleGateway)
    {
    }

    public function execute(): array
    {
        return $this->articleGateway->getAll();
    }
}
