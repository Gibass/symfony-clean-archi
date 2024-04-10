<?php

namespace App\Domain\Category\Gateway;

use App\Domain\Article\Entity\TaxonomyInterface;
use App\Domain\CRUD\Gateway\CrudGatewayInterface;
use Pagerfanta\Adapter\AdapterInterface;

interface CategoryGatewayInterface extends CrudGatewayInterface
{
    public function getById(int $id): ?TaxonomyInterface;

    public function getAll(): array;

    public function getBySlug(string $slug): ?TaxonomyInterface;

    public function getFacetCategories(): array;

    public function getArticlePaginated(int $id): AdapterInterface;
}
