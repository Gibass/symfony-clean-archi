<?php

namespace App\UserInterface\Controller\Admin\Category;

use App\Domain\Category\Gateway\CategoryGatewayInterface;
use App\Domain\CRUD\Request\UpdateRequest;
use App\Domain\CRUD\UseCase\Update;
use App\Domain\CRUD\Validator\TaxonomyValidator;
use App\Infrastructure\Doctrine\Entity\Category;
use App\UserInterface\Form\CategoryType;
use Assert\AssertionFailedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class UpdateController extends AbstractController
{
    #[Route('/admin/edit/category/{id}', name: 'admin_edit_category', requirements: ['id' => Requirement::DIGITS])]
    public function update(int $id, Request $request, Update $update, CategoryGatewayInterface $gateway, TaxonomyValidator $validator): Response
    {
        $category = $gateway->getById($id);

        if (!$category instanceof Category) {
            throw $this->createNotFoundException('Category with id : ' . $id . ' not found');
        }

        $form = $this->createForm(CategoryType::class, $category)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $updateRequest = new UpdateRequest($category);
                $update->execute($updateRequest, $gateway, $validator);

                $this->addFlash('success', 'The category have been updated successfully');

                return $this->redirectToRoute('admin_listing_categories');
            } catch (AssertionFailedException $e) {
                $form->get($e->getPropertyPath())->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render('admin/pages/categories/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
