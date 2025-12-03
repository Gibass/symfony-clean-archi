<?php

namespace App\Taxonomy\UserInterface\Controller;

use App\Taxonomy\Domain\UseCase\SaveTaxonomy;
use App\Taxonomy\UserInterface\Form\TaxonomyType;
use App\Taxonomy\UserInterface\Presenter\CreateTaxonomyPresenterHTML;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CreateTaxonomyController extends AbstractController
{
    #[Route('/admin/taxonomy/create', name: 'taxonomy.create', methods: ['GET', 'POST'])]
    public function create(
        Request $request,
        SaveTaxonomy $saveTaxonomy,
        CreateTaxonomyPresenterHTML $presenter
    ): Response {
        $form = $this->createForm(TaxonomyType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $saveTaxonomy->execute($form->getData());

            $this->addFlash('success', 'Taxonomy created successfully.');

            return $this->redirectToRoute('taxonomy.list');
        }

        return $presenter->present($form);
    }
}
