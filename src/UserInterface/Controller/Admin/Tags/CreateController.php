<?php

namespace App\UserInterface\Controller\Admin\Tags;

use App\Domain\CRUD\Request\CreateRequest;
use App\Domain\CRUD\UseCase\Create;
use App\Domain\CRUD\Validator\TaxonomyValidator;
use App\Domain\Tag\Gateway\TagGatewayInterface;
use App\Infrastructure\Doctrine\Entity\Tag;
use App\UserInterface\Form\TagType;
use Assert\AssertionFailedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateController extends AbstractController
{
    #[Route('/admin/create/tag', name: 'admin_create_tag')]
    public function create(Request $request, Create $create, TagGatewayInterface $tagGateway, TaxonomyValidator $tagValidator): Response
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $createRequest = new CreateRequest($tag);
                $create->execute($createRequest, $tagGateway, $tagValidator);

                $this->addFlash('success', 'The tag have been created successfully');

                return $this->redirectToRoute('admin_listing_tags');
            } catch (AssertionFailedException $e) {
                $form->get($e->getPropertyPath())->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render('admin/pages/tags/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
