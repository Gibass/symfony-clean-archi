<?php

namespace App\Domain\Article\Response;

use App\Domain\Article\Entity\ArticleInterface;

readonly class ShowResponse
{
    public function __construct(private ArticleInterface $article)
    {
    }

    public function getArticle(): ArticleInterface
    {
        return $this->article;
    }
}
