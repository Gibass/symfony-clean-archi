<?php

namespace App\Article\UserInterface\Presenter\Web;

use App\Article\Domain\Model\Entity\Article;
use App\Core\UserInterface\Presenter\AbstractWebPresenter;
use Symfony\Component\HttpFoundation\Response;

class ListArticlePresenterHTML extends AbstractWebPresenter
{
    public function present(array $articles): Response
    {
        return $this->render('pages/article/list/list.html.twig', [
            'articles' => $articles
        ]);
    }
}
