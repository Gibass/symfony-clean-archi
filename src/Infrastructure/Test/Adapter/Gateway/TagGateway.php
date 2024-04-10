<?php

namespace App\Infrastructure\Test\Adapter\Gateway;

use App\Domain\Article\Entity\TaxonomyInterface;
use App\Domain\CRUD\Entity\CrudEntityInterface;
use App\Domain\Tag\Gateway\TagGatewayInterface;
use App\Infrastructure\Doctrine\Entity\Article;
use App\Infrastructure\Doctrine\Entity\Tag;
use App\Infrastructure\Doctrine\Entity\User;
use Pagerfanta\Adapter\AdapterInterface;

class TagGateway implements TagGatewayInterface
{
    public const SLUGS = [
        1 => 'image',
        2 => 'photo',
    ];

    public function getByIds(array $ids): array
    {
        return [
            (new Tag('Image', 'image'))->setId(1),
            (new Tag('Photo', 'photo'))->setId(2),
            (new Tag('Video', 'video'))->setId(3),
        ];
    }

    public function getAll(): array
    {
        return [
            (new Tag('Image', 'image'))->setId(1),
            (new Tag('Photo', 'photo'))->setId(2),
            (new Tag('Video', 'video'))->setId(3),
        ];
    }

    public function getBySlug(string $slug): ?TaxonomyInterface
    {
        if ($slug === 'no-tag') {
            return null;
        }

        return match ($slug) {
            'image' => (new Tag('Image', $slug))->setId(1),
            'photo' => (new Tag('Photo', $slug))->setId(2),
            default => (new Tag(ucfirst($slug), $slug))->setId(3),
        };
    }

    public function getPopularTag(): array
    {
        return [
            new Tag('Image', 'image'),
            new Tag('Photo', 'photo'),
            new Tag('Video', 'video'),
        ];
    }

    public function getArticlePaginated(int $id): AdapterInterface
    {
        $articles = [];

        $range = match ($id) {
            1 => range(1, 5),
            2 => range(6, 10),
            default => [],
        };

        $slug = self::SLUGS[$id] ?? 'Null';

        foreach ($range as $i) {
            $articles[$i] = (new Article())
                ->setOwner((new User())->setFirstname('Low')->setLastname('Cost'))
            ->setId($i)->addTags([new Tag($slug, $slug)])
            ;
        }

        return new class($articles) implements AdapterInterface {
            private array $articles;

            public function __construct(array $articles)
            {
                $this->articles = $articles;
            }

            public function getNbResults(): int
            {
                return 5;
            }

            public function getSlice(int $offset, int $length): iterable
            {
                return \array_slice($this->articles, $offset, $length);
            }
        };
    }

    public function getPaginatedAdapter(array $conditions = []): AdapterInterface
    {
        return new class() implements AdapterInterface {
            private array $categories;

            public function __construct()
            {
                foreach (range(1, 5) as $i) {
                    $this->categories[] = (new Tag('Tag-' . $i, 'tag-' . $i))->setId($i);
                }
            }

            public function getNbResults(): int
            {
                return \count($this->categories);
            }

            public function getSlice(int $offset, int $length): iterable
            {
                return \array_slice($this->categories, $offset, $length);
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

    public function getByIdentifier(int|string $identifier): ?CrudEntityInterface
    {
        if (\is_int($identifier)) {
            return $this->getById($identifier);
        }

        return $this->getBySlug($identifier);
    }

    public function getById(int $id): ?TaxonomyInterface
    {
        if ($id <= 0) {
            return null;
        }

        return (new Tag('Empty', 'empty'))->setId($id);
    }
}
