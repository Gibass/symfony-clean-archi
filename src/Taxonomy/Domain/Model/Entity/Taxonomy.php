<?php

namespace App\Taxonomy\Domain\Model\Entity;

use App\Taxonomy\Infrastructure\Adapter\Repository\TaxonomyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaxonomyRepository::class)]
class Taxonomy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public(set) ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    public ?string $name = null;
}
