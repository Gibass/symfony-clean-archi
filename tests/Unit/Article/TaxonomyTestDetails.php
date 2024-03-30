<?php

namespace App\Tests\Unit\Article;

use App\Domain\Article\Entity\TaxonomyInterface;
use PHPUnit\Framework\MockObject\MockObject;

readonly class TaxonomyTestDetails
{
    public function __construct(private int $id, private array $data = [])
    {
    }

    public static function create(int $id, array $data = []): static
    {
        return new self($id, $data);
    }

    public function getClass(): string
    {
        return TaxonomyInterface::class;
    }

    public function generateMockRelation(TaxonomyInterface&MockObject $taxonomy): ?TaxonomyInterface
    {
        if ($this->id === 0) {
            return null;
        }

        foreach ($this->data['fields'] as $field => $value) {
            $method = 'get' . ucfirst($field);
            if (method_exists($taxonomy, $method)) {
                $taxonomy->method($method)->willReturn($value);
            }
        }

        return $taxonomy;
    }

    public function getFields(string $key): mixed
    {
        return $this->data['fields'][$key] ?? null;
    }
}
