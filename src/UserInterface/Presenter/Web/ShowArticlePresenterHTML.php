<?php

namespace App\UserInterface\Presenter\Web;

use App\Domain\Article\Presenter\ShowPresenterInterface;
use App\Domain\Article\Response\ShowResponse;
use Symfony\Component\HttpFoundation\Response;

class ShowArticlePresenterHTML extends AbstractWebPresenter implements ShowPresenterInterface
{
    public function present(ShowResponse $response): Response
    {
        return $this->render('pages/article/show.html.twig', [
            'article' => $response->getArticle(),
        ]);
    }
}
