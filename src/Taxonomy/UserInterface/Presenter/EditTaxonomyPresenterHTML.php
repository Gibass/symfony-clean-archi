<?php

namespace App\Taxonomy\UserInterface\Presenter;

use App\Core\UserInterface\Presenter\AbstractWebPresenter;
use App\Taxonomy\Domain\Model\Entity\Taxonomy;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

class EditTaxonomyPresenterHTML extends AbstractWebPresenter
{
    public function present(Taxonomy $taxonomy, FormInterface $form): Response
    {
        return $this->render('pages/taxonomy/edit/edit.html.twig', [
            'taxonomy' => $taxonomy,
            'form' => $form->createView(),
        ]);
    }
}
