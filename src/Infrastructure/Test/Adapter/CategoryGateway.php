<?php

namespace App\Infrastructure\Test\Adapter;

use App\Domain\Article\Entity\Article;
use App\Domain\Article\Entity\Category;
use App\Domain\Category\Gateway\CategoryGatewayInterface;
use Pagerfanta\Adapter\AdapterInterface;

class CategoryGateway implements CategoryGatewayInterface
{
    public function getBySlug(string $slug): ?Category
    {
        if ($slug === 'no-category') {
            return null;
        }

        return new Category(ucfirst($slug), $slug);
    }

    public function getPaginatedAdapter(array $conditions = []): AdapterInterface
    {
        $articles = [];

        $range = match ($conditions['slug'] ?? null) {
            'men' => range(1, 5),
            default => [],
        };

        foreach ($range as $i) {
            $articles[$i] = (new Article())->setId($i)->setCategory(new Category($conditions['slug'], $conditions['slug']));
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
}
