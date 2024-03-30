<?php

namespace App\Infrastructure\Test\Adapter\Gateway;

use App\Domain\Article\Entity\TaxonomyInterface;
use App\Domain\Category\Gateway\CategoryGatewayInterface;
use App\Infrastructure\Doctrine\Entity\Article;
use App\Infrastructure\Doctrine\Entity\Category;
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
            default => new Category(ucfirst($slug), $slug),
        };
    }

    public function getFacetCategories(): array
    {
        return [
            ['id' => 1, 'slug' => 'men', 'title' => 'Men', 'total' => 3],
            ['id' => 2, 'slug' => 'women', 'title' => 'Women', 'total' => 1],
        ];
    }

    public function getPaginatedAdapter(array $conditions = []): AdapterInterface
    {
        $articles = [];

        $range = match ($conditions['id'] ?? null) {
            1 => range(1, 5),
            default => [],
        };

        foreach ($range as $i) {
            $articles[$i] = (new Article())->setId($i)->setCategory(new Category('men', 'men'));
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
