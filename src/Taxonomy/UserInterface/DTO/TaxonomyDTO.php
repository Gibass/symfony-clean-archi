<?php

namespace App\Taxonomy\UserInterface\DTO;

use App\Core\Domain\Model\DTO\DTOEntityInterface;
use App\Taxonomy\Domain\Model\Entity\Taxonomy;
use Symfony\Component\ObjectMapper\Attribute\Map;

#[Map(target: Taxonomy::class)]
class TaxonomyDTO implements DTOEntityInterface
{
    #[Map(if: '!is_null')]
    public ?int $id = null;
    public ?string $name = null;

    public function getClass(): string
    {
        return Taxonomy::class;
    }

    public function getPrimaryKey(): string
    {
        return 'id';
    }

    public function getPrimaryValue(): ?int
    {
        return $this->id;
    }
}
