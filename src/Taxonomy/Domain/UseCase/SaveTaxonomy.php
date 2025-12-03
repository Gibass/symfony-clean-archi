<?php

namespace App\Taxonomy\Domain\UseCase;

use App\Core\Domain\Manager\DTOManagerInterface;
use App\Core\Domain\Manager\EntityManagerInterface;
use App\Taxonomy\Domain\Model\Entity\Taxonomy;
use App\Taxonomy\UserInterface\DTO\TaxonomyDTO;

readonly class SaveTaxonomy
{
    public function __construct(private EntityManagerInterface $entityManager, private DTOManagerInterface $dtoManager)
    {
    }

    public function execute(TaxonomyDTO $taxonomyDTO): Taxonomy
    {
        $taxonomy = $this->dtoManager->transform($taxonomyDTO);

        $this->entityManager->save($taxonomy);
        $this->entityManager->flush();

        return $taxonomy;
    }
}
