<?php

namespace App\Taxonomy\UserInterface\Controller;

use App\Core\Domain\Manager\DTOManagerInterface;
use App\Taxonomy\Domain\Model\Entity\Taxonomy;
use App\Taxonomy\Domain\UseCase\SaveTaxonomy;
use App\Taxonomy\UserInterface\DTO\TaxonomyDTO;
use App\Taxonomy\UserInterface\Form\TaxonomyType;
use App\Taxonomy\UserInterface\Presenter\EditTaxonomyPresenterHTML;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EditTaxonomyController extends AbstractController
{
    #[Route('/admin/taxonomy/{id}/edit', name: 'taxonomy.edit', methods: ['GET', 'POST'])]
    public function edit(
        Request                   $request,
        Taxonomy                  $taxonomy,
        DTOManagerInterface       $DTOManager,
        SaveTaxonomy              $saveArticle,
        EditTaxonomyPresenterHTML $presenter
    ): Response
    {
        $dto = $DTOManager->createFrom(TaxonomyDTO::class, $taxonomy);

        $form = $this->createForm(TaxonomyType::class, $dto)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $saveArticle->execute($dto);

            $this->addFlash('success', 'Taxonomy updated successfully.');

            return $this->redirectToRoute('taxonomy.list');
        }

        return $presenter->present($taxonomy, $form);
    }
}
