<?php

namespace App\Infrastructure\Test\Adapter;

use App\Domain\Article\Entity\Article;
use App\Domain\Article\Entity\Tag;
use App\Domain\Tag\Gateway\TagGatewayInterface;
use Pagerfanta\Adapter\AdapterInterface;

class TagGateway implements TagGatewayInterface
{
    public const SLUGS = [
        1 => 'image',
        2 => 'photo',
    ];

    public function getBySlug(string $slug): ?Tag
    {
        if ($slug === 'no-tag') {
            return null;
        }

        return match ($slug) {
            'image' => (new Tag('Image', $slug))->setId(1),
            'photo' => (new Tag('Photo', $slug))->setId(2),
            default => new Tag(ucfirst($slug), $slug),
        };
    }

    public function getPaginatedAdapter(array $conditions = []): AdapterInterface
    {
        $articles = [];

        $range = match ($conditions['id'] ?? null) {
            1 => range(1, 5),
            2 => range(6, 10),
            default => [],
        };

        $slug = self::SLUGS[$conditions['id']] ?? 'Null';

        foreach ($range as $i) {
            $articles[$i] = (new Article())->setId($i)->addTags([new Tag($slug, $slug)]);
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

    public function getPopularTag(): array
    {
        return [];
    }
}
