<?php

namespace App\Infrastructure\Test\Adapter;

use App\Domain\Article\Entity\Article;
use App\Domain\Article\Entity\Tag;
use App\Domain\Article\Gateway\ArticleGatewayInterface;
use Pagerfanta\Adapter\AdapterInterface;

class ArticleGateway implements ArticleGatewayInterface
{
    public function getPublishedById(int $id): ?Article
    {
        if ($id > 0) {
            return (new Article())
                ->setId($id)
                ->setTitle('Custom Title')
                ->setSlug('custom-article')
                ->setContent('Custom Content')
                ->addTags([new Tag('Photo', 'photo'), new Tag('Image', 'image')])
                ->setCreatedAt(\DateTime::createFromFormat('d/m/Y', '15/05/2023'))
                ->setPublishedAt(\DateTimeImmutable::createFromFormat('d/m/Y', '15/05/2023'))
            ;
        }

        return null;
    }

    public function getPaginatedAdapter(array $conditions = []): AdapterInterface
    {
        return new class() implements AdapterInterface {
            private array $articles;

            public function __construct()
            {
                foreach (range(1, 25) as $i) {
                    $this->articles[] = (new Article())->setId($i);
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

    public function getLastArticles(): array
    {
        return [];
    }
}
