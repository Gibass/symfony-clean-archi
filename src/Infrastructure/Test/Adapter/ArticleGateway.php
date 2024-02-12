<?php

namespace App\Infrastructure\Test\Adapter;

use App\Domain\Article\Entity\Article;
use App\Domain\Article\Entity\Image;
use App\Domain\Article\Gateway\ArticleGatewayInterface;
use Pagerfanta\Adapter\AdapterInterface;

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
                ->setCreatedAt(\DateTime::createFromFormat('d/m/Y', '15/05/2023'))
                ->setPublishedAt(\DateTimeImmutable::createFromFormat('d/m/Y', '15/05/2023'))
            ;
        }

        return null;
    }

    public function getPublishedById(int $id): ?Article
    {
        return $this->getById($id);
    }

    public function getPaginatedAdapter(): AdapterInterface
    {
        return new class() implements AdapterInterface {
            private array $articles;

            public function __construct()
            {
                for ($i = 0; $i < 25; ++$i) {
                    $this->articles[] = (new Article())->setId($i + 1);
                }
            }

            public function getNbResults(): int
            {
                return \count($this->articles);
            }

            public function getSlice(int $offset, int $length): iterable
            {
                return \array_slice($this->articles, $offset, $length);
            }
        };
    }
}
