<?php

namespace App\UserInterface\Controller\Admin\Category;

use App\Domain\Category\Gateway\CategoryGatewayInterface;
use App\Domain\CRUD\Request\CreateRequest;
use App\Domain\CRUD\UseCase\Create;
use App\Domain\CRUD\Validator\TaxonomyValidator;
use App\Infrastructure\Doctrine\Entity\Category;
use App\UserInterface\Form\CategoryType;
use Assert\AssertionFailedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateController extends AbstractController
{
    #[Route('/admin/create/category', name: 'admin_create_category')]
    public function create(Request $request, Create $create, CategoryGatewayInterface $categoryGateway, TaxonomyValidator $categoryValidator): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $createRequest = new CreateRequest($category);
                $create->execute($createRequest, $categoryGateway, $categoryValidator);

                $this->addFlash('success', 'The category have been created successfully');

                return $this->redirectToRoute('admin_listing_categories');
            } catch (AssertionFailedException $e) {
                $form->get($e->getPropertyPath())->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render('admin/pages/categories/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
