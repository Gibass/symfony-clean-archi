<?php

namespace App\Taxonomy\UserInterface\Controller;

use App\Taxonomy\Domain\UseCase\ListTaxonomy;
use App\Taxonomy\UserInterface\Presenter\ListTaxonomyPresenterHTML;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListTaxonomyController extends AbstractController
{
    #[Route('/admin/taxonomies', name: 'taxonomy.list', methods: ['GET'])]
    public function index(ListTaxonomy $listTaxonomy, ListTaxonomyPresenterHTML $presenter): Response
    {
        return $presenter->present($listTaxonomy->execute());
    }
}
