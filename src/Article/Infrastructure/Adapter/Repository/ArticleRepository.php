<?php

namespace App\Article\Infrastructure\Adapter\Repository;

use App\Article\Domain\Gateway\ArticleGatewayInterface;
use App\Article\Domain\Model\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository implements ArticleGatewayInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function getAll(): array
    {
        return $this->findAll();
    }
}
