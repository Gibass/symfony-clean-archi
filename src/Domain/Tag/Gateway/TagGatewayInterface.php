<?php

namespace App\Domain\Tag\Gateway;

use App\Domain\Article\Entity\Tag;
use Pagerfanta\Adapter\AdapterInterface;

interface TagGatewayInterface
{
    public function getBySlug(string $slug): ?Tag;

    public function getPaginatedAdapter(Tag $tag): AdapterInterface;
}
