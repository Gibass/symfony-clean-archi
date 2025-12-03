<?php

declare(strict_types=1);

namespace App\Article\Domain\UseCase;

use App\Article\Domain\Model\Entity\Article;
use App\Article\UserInterface\DTO\ArticleDTO;
use App\Core\Domain\Manager\DTOManagerInterface;
use App\Core\Domain\Manager\EntityManagerInterface;

readonly class SaveArticle
{
    public function __construct(private EntityManagerInterface $entityManager, private DTOManagerInterface $dtoManager)
    {
    }

    public function execute(?ArticleDTO $articleDTO): ?Article
    {
        $article = $this->dtoManager->transform($articleDTO);

        $this->entityManager->save($article);
        $this->entityManager->flush();

        return $article;
    }
}
