<?php

namespace App\UserInterface\Controller\Admin\Article;

use App\Domain\Article\Gateway\ArticleGatewayInterface;
use App\Domain\CRUD\Request\CreateRequest;
use App\Domain\CRUD\UseCase\Create;
use App\Domain\CRUD\Validator\ArticleValidator;
use App\UserInterface\DTO\ArticleDTO;
use App\UserInterface\Form\ArticleType;
use Assert\AssertionFailedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class CreateController extends AbstractController
{
    #[Route('/admin/create/article', name: 'admin_create_article')]
    public function createArticle(Request $request, Create $create, ArticleGatewayInterface $gateway, ArticleValidator $validator): Response
    {
        $article = new ArticleDTO();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $request = new CreateRequest($article->toArray());
                $create->execute($request, $gateway, $validator);

                $this->addFlash('success', 'The article have been created successfully');

                return $this->redirectToRoute('admin_listing_articles');
            } catch (AssertionFailedException $e) {
                $form->get($e->getPropertyPath())->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render('admin/pages/articles/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
