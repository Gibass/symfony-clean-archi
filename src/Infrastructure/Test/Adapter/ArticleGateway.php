<?php

namespace App\Infrastructure\Test\Adapter;

use App\Domain\Article\Entity\Article;
use App\Domain\Article\Gateway\ArticleGatewayInterface;

class ArticleGateway implements ArticleGatewayInterface
{
    public function getById(int $id): ?Article
    {
        if ($id > 0) {
            return (new Article())
                ->setId($id)
                ->setTitle('Custom Title')
                ->setSlug('custom-article')
                ->setContent('Custom Content')
            ;
        }

        return null;
    }
}
