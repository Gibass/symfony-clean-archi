<?php

namespace App\Domain\Article\Response;

use App\Domain\Article\Entity\Article;

readonly class ShowResponse
{
    public function __construct(private Article $article)
    {
    }

    public function getArticle(): Article
    {
        return $this->article;
    }
}
