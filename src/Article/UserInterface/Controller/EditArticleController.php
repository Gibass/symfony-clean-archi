<?php

namespace App\Article\UserInterface\Controller;

use App\Article\Domain\Model\Entity\Article;
use App\Article\Domain\UseCase\SaveArticle;
use App\Article\UserInterface\DTO\ArticleDTO;
use App\Article\UserInterface\Form\ArticleType;
use App\Article\UserInterface\Presenter\Web\EditArticlePresenterHTML;
use App\Core\Domain\Manager\DTOManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EditArticleController extends AbstractController
{
    #[Route('/admin/article/{id}/edit', name: 'article.edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Article $article,
        DTOManagerInterface $DTOManager,
        SaveArticle $saveArticle,
        EditArticlePresenterHTML $presenter
    ): Response {
        $dto = $DTOManager->createFrom(ArticleDTO::class, $article);

        $form = $this->createForm(ArticleType::class, $dto)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $saveArticle->execute($dto);

            $this->addFlash('success', 'Article updated successfully.');

            return $this->redirectToRoute('article.list');
        }

        return $presenter->present($article, $form);
    }
}
