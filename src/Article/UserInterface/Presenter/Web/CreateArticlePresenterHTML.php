<?php

declare(strict_types=1);

namespace App\Article\UserInterface\Presenter\Web;

use App\Core\UserInterface\Presenter\AbstractWebPresenter;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

class CreateArticlePresenterHTML extends AbstractWebPresenter
{
    public function present(FormInterface $form): Response
    {
        return $this->render('pages/article/create/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
