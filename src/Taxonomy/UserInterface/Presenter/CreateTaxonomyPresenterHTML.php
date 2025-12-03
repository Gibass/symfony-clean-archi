<?php

namespace App\Taxonomy\UserInterface\Presenter;

use App\Core\UserInterface\Presenter\AbstractWebPresenter;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

class CreateTaxonomyPresenterHTML extends AbstractWebPresenter
{
    public function present(FormInterface $form): Response
    {
        return $this->render('pages/taxonomy/create/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
