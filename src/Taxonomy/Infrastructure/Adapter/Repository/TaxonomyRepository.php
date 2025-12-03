<?php

namespace App\Taxonomy\Infrastructure\Adapter\Repository;

use App\Taxonomy\Domain\Gateway\TaxonomyGatewayInterface;
use App\Taxonomy\Domain\Model\Entity\Taxonomy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Taxonomy>
 */
class TaxonomyRepository extends ServiceEntityRepository implements TaxonomyGatewayInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Taxonomy::class);
    }

    public function getAll(): array
    {
        return $this->findAll();
    }
}
