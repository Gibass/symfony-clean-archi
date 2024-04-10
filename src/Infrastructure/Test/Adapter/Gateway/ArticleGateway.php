<?php

namespace App\Infrastructure\Test\Adapter\Gateway;

use App\Domain\Article\Entity\ArticleInterface;
use App\Domain\Article\Gateway\ArticleGatewayInterface;
use App\Domain\CRUD\Entity\CrudEntityInterface;
use App\Infrastructure\Doctrine\Entity\Article;
use App\Infrastructure\Doctrine\Entity\Tag;
use App\Infrastructure\Doctrine\Entity\User;
use Pagerfanta\Adapter\AdapterInterface;

class ArticleGateway implements ArticleGatewayInterface
{
    public function getByIdentifier(int|string $identifier): ?CrudEntityInterface
    {
        return $this->getById($identifier);
    }

    public function getPublishedById(int $id): ?ArticleInterface
    {
        if ($id > 0) {
            return (new Article())
                ->setId($id)
                ->setTitle('Custom Title')
                ->setSlug('custom-article')
                ->setContent('Custom Content')
                ->addTags([new Tag('Photo', 'photo'), new Tag('Image', 'image')])
                ->setOwner((new User())->setFirstname('Jean')->setLastname('Doe'))
                ->setCreatedAt(\DateTime::createFromFormat('d/m/Y', '15/05/2023'))
                ->setPublishedAt(\DateTimeImmutable::createFromFormat('d/m/Y', '15/05/2023'))
            ;
        }

        return null;
    }

    public function getById(int $id): ?ArticleInterface
    {
        return $this->getPublishedById($id);
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
                    $this->articles[] = (new Article())->setId($i)
                        ->setOwner((new User())->setFirstname('John')->setLastname('Place'))
                    ;
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

    public function create(CrudEntityInterface $entity): CrudEntityInterface
    {
        return $entity->setId(1);
    }

    public function update(CrudEntityInterface $entity): CrudEntityInterface
    {
        return $entity;
    }

    public function delete(CrudEntityInterface $entity): bool
    {
        if ($entity->getId() === 10) {
            return false;
        }

        return true;
    }
}
