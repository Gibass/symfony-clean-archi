<?php

namespace App\Infrastructure\Test\Adapter\Gateway;

use App\Domain\Article\Entity\TaxonomyInterface;
use App\Domain\Category\Gateway\CategoryGatewayInterface;
use App\Domain\CRUD\Entity\CrudEntityInterface;
use App\Infrastructure\Doctrine\Entity\Article;
use App\Infrastructure\Doctrine\Entity\Category;
use App\Infrastructure\Doctrine\Entity\User;
use Pagerfanta\Adapter\AdapterInterface;

class CategoryGateway implements CategoryGatewayInterface
{
    public function getBySlug(string $slug): ?TaxonomyInterface
    {
        if ($slug === 'no-category') {
            return null;
        }

        return match ($slug) {
            'men' => (new Category('Men', $slug))->setId(1),
            default => (new Category(ucfirst($slug), $slug))->setId(2),
        };
    }

    public function getFacetCategories(): array
    {
        return [
            ['id' => 1, 'slug' => 'men', 'title' => 'Men', 'total' => 3],
            ['id' => 2, 'slug' => 'women', 'title' => 'Women', 'total' => 1],
        ];
    }

    public function getArticlePaginated(int $id): AdapterInterface
    {
        $articles = [];

        $range = match ($id) {
            1 => range(1, 5),
            default => [],
        };

        foreach ($range as $i) {
            $articles[$i] = (new Article())
                ->setOwner((new User())->setFirstname('Low')->setLastname('Cost'))
            ->setId($i)->setCategory(new Category('men', 'men'))
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
                    $this->categories[] = (new Category('Men-' . $i, 'men-' . $i))->setId($i);
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

    public function getAll(): array
    {
        return [
            (new Category('men', 'men'))->setId(1),
            (new Category('women', 'women'))->setId(2),
        ];
    }

    public function getById(int $id): ?TaxonomyInterface
    {
        if ($id <= 0) {
            return null;
        }

        return (new Category('Empty Cat', 'empty-cat'))->setId($id);
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
}
