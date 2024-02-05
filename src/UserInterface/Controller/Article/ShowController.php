<?php

namespace App\UserInterface\Controller\Article;

use App\Domain\Article\Exception\ArticleNotFoundException;
use App\Domain\Article\Request\ShowRequest;
use App\Domain\Article\UseCase\Show;
use App\UserInterface\Presenter\Web\ShowArticlePresenterHTML;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class ShowController
{
    #[Route('/article/{id}.html', name: 'article_show')]
    public function show(int $id, Show $show, ShowArticlePresenterHTML $presenter): Response
    {
        try {
            return $show->execute(new ShowRequest($id), $presenter);
        } catch (ArticleNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}
