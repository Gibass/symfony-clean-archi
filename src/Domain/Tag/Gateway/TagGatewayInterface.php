<?php

namespace App\Domain\Tag\Gateway;

use App\Domain\Article\Entity\TaxonomyInterface;
use App\Domain\CRUD\Gateway\CrudGatewayInterface;
use Pagerfanta\Adapter\AdapterInterface;

interface TagGatewayInterface extends CrudGatewayInterface
{
    public function getByIds(array $ids): array;

    public function getAll(): array;

    public function getBySlug(string $slug): ?TaxonomyInterface;

    public function getById(int $id): ?TaxonomyInterface;

    public function getPopularTag(): array;

    public function getArticlePaginated(int $id): AdapterInterface;
}
