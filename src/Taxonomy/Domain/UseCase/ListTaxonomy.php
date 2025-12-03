<?php

namespace App\Taxonomy\Domain\UseCase;

use App\Taxonomy\Domain\Gateway\TaxonomyGatewayInterface;

readonly class ListTaxonomy
{
    public function __construct(private TaxonomyGatewayInterface $taxonomyGateway)
    {
    }

    public function execute(): array
    {
        return $this->taxonomyGateway->getAll();
    }
}
