<?php

namespace App\UserInterface\Controller\Admin\Article;

use App\Domain\Article\Gateway\ArticleGatewayInterface;
use App\Domain\CRUD\Request\UpdateRequest;
use App\Domain\CRUD\UseCase\Update;
use App\Domain\CRUD\Validator\ArticleValidator;
use App\UserInterface\Form\ArticleType;
use Assert\AssertionFailedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class UpdateController extends AbstractController
{
    #[Route('/admin/edit/article/{id}', name: 'admin_edit_article', requirements: ['id' => Requirement::DIGITS])]
    public function update(int $id, Request $request, Update $update, ArticleGatewayInterface $repository, ArticleValidator $validator): Response
    {
        $article = $repository->getById($id);

        if (!$article) {
            throw $this->createNotFoundException('Article with id : ' . $id . ' not found');
        }

        $form = $this->createForm(ArticleType::class, $article)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $updateRequest = new UpdateRequest($article);
                $update->execute($updateRequest, $repository, $validator);

                $this->addFlash('success', 'The article have been updated successfully');

                return $this->redirectToRoute('admin_listing_articles');
            } catch (AssertionFailedException $e) {
                $form->get($e->getPropertyPath())->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render('admin/pages/articles/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
