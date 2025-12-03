<?php

namespace App\Article\UserInterface\Presenter\Web;

use App\Article\Domain\Model\Entity\Article;
use App\Core\UserInterface\Presenter\AbstractWebPresenter;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

class EditArticlePresenterHTML extends AbstractWebPresenter
{
    public function present(Article $article, FormInterface $form): Response
    {
        return $this->render('pages/article/edit/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }
}
