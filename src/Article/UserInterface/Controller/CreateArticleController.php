<?php

declare(strict_types=1);

namespace App\Article\UserInterface\Controller;

use App\Article\Domain\UseCase\SaveArticle;
use App\Article\UserInterface\Form\ArticleType;
use App\Article\UserInterface\Presenter\Web\CreateArticlePresenterHTML;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CreateArticleController extends AbstractController
{
    #[Route('/admin/article/create', name: 'article.create', methods: ['GET', 'POST'])]
    public function create(
        Request                    $request,
        SaveArticle                $saveArticle,
        CreateArticlePresenterHTML $presenter
    ): Response {
        $form = $this->createForm(ArticleType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $saveArticle->execute($form->getData());

            $this->addFlash('success', 'Article created successfully.');

            return $this->redirectToRoute('article.list');
        }

        return $presenter->present($form);
    }
}
