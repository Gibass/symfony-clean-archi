<?php

namespace App\Taxonomy\Domain\Gateway;

interface TaxonomyGatewayInterface
{
    public function getAll(): array;
}
