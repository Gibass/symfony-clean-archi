<?php

namespace App\Infrastructure\Test\Adapter;

use App\Domain\Article\Entity\Article;
use App\Domain\Article\Entity\Tag;
use App\Domain\Tag\Gateway\TagGatewayInterface;
use Pagerfanta\Adapter\AdapterInterface;

class TagGateway implements TagGatewayInterface
{
    public function getBySlug(string $slug): ?Tag
    {
        if ($slug === 'no-tag') {
            return null;
        }

        return new Tag(ucfirst($slug), $slug);
    }

    public function getPaginatedAdapter(array $conditions = []): AdapterInterface
    {
        $articles = [];

        $range = match ($conditions['slug'] ?? null) {
            'image' => range(1, 5),
            'photo' => range(6, 10),
            default => [],
        };

        foreach ($range as $i) {
            $articles[$i] = (new Article())->setId($i)->addTags([new Tag($conditions['slug'], $conditions['slug'])]);
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
