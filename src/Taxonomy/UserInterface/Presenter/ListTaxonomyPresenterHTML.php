<?php

namespace App\Taxonomy\UserInterface\Presenter;

use App\Core\UserInterface\Presenter\AbstractWebPresenter;
use Symfony\Component\HttpFoundation\Response;

class ListTaxonomyPresenterHTML extends AbstractWebPresenter
{
    public function present(array $taxonomies): Response
    {
        return $this->render('pages/taxonomy/list/list.html.twig', [
            'taxonomies' => $taxonomies
        ]);
    }
}
