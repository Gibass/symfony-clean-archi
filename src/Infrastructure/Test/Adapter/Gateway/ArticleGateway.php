<?php

namespace App\Infrastructure\Test\Adapter\Gateway;

use App\Domain\Article\Entity\ArticleInterface;
use App\Domain\Article\Gateway\ArticleGatewayInterface;
use App\Domain\CRUD\Entity\CrudEntityInterface;
use App\Domain\CRUD\Entity\PostedData;
use App\Infrastructure\Doctrine\Entity\Article;
use App\Infrastructure\Doctrine\Entity\Tag;
use Pagerfanta\Adapter\AdapterInterface;

class ArticleGateway implements ArticleGatewayInterface
{
    public function getPublishedById(int $id): ?ArticleInterface
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

    public function getLastArticles(): array
    {
        return [
            (new Article())->setId(1)->setTitle('Custom title'),
            (new Article())->setId(2)->setTitle('Lorem title'),
            (new Article())->setId(3)->setTitle('Ipsum title'),
        ];
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

    public function create(PostedData $data): CrudEntityInterface
    {
        return (new Article())
            ->setId(1)
            ->setTitle($data->get('title'))
            ->setDescription($data->get('description'))
            ->setContent($data->get('content'))
            ->setStatus($data->get('status'))
        ;
    }
}
