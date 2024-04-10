<?php

namespace App\UserInterface\Controller\Admin\Tags;

use App\Domain\CRUD\Request\UpdateRequest;
use App\Domain\CRUD\UseCase\Update;
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
use Symfony\Component\Routing\Requirement\Requirement;

class UpdateController extends AbstractController
{
    #[Route('/admin/edit/tag/{id}', name: 'admin_edit_tag', requirements: ['id' => Requirement::DIGITS])]
    public function update(int $id, Request $request, Update $update, TagGatewayInterface $gateway, TaxonomyValidator $validator): Response
    {
        $tag = $gateway->getById($id);

        if (!$tag instanceof Tag) {
            throw $this->createNotFoundException('Tag with id : ' . $id . ' not found');
        }

        $form = $this->createForm(TagType::class, $tag)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $updateRequest = new UpdateRequest($tag);
                $update->execute($updateRequest, $gateway, $validator);

                $this->addFlash('success', 'The tag have been updated successfully');

                return $this->redirectToRoute('admin_listing_tags');
            } catch (AssertionFailedException $e) {
                $form->get($e->getPropertyPath())->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render('admin/pages/tags/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
