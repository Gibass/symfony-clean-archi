<?php

declare(strict_types=1);

namespace App\Article\UserInterface\Controller;

use App\Article\Domain\UseCase\ListArticle;
use App\Article\UserInterface\Presenter\Web\ListArticlePresenterHTML;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListArticleController extends AbstractController
{
    #[Route('/admin/articles', name: 'article.list', methods: ['GET'])]
    public function index(ListArticle $listArticle, ListArticlePresenterHTML $presenter): Response
    {
        return $presenter->present($listArticle->execute());
    }
}
