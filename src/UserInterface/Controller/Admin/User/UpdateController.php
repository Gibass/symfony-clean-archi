<?php

namespace App\UserInterface\Controller\Admin\User;

use App\Domain\CRUD\Exception\InvalidCrudEntityException;
use App\Domain\CRUD\Request\UpdateRequest;
use App\Domain\CRUD\UseCase\Update;
use App\Domain\CRUD\Validator\UserValidator;
use App\Domain\Security\Gateway\UserGatewayInterface;
use App\UserInterface\Form\UserType;
use Assert\AssertionFailedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class UpdateController extends AbstractController
{
    #[Route('/admin/edit/user/{id}', name: 'admin_edit_user', requirements: ['id' => Requirement::DIGITS])]
    public function update(int $id, Request $request, Update $update, UserGatewayInterface $repository, UserValidator $validator): Response
    {
        $user = $repository->getByIdentifier($id);

        if (!$user) {
            throw $this->createNotFoundException('User with id : ' . $id . ' not found');
        }

        $form = $this->createForm(UserType::class, $user)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $updateRequest = new UpdateRequest($user);
                $update->execute($updateRequest, $repository, $validator);

                $this->addFlash('success', 'The User have been updated successfully');

                return $this->redirectToRoute('admin_listing_articles');
            } catch (AssertionFailedException $e) {
                $form->get($e->getPropertyPath())->addError(new FormError($e->getMessage()));
            } catch (InvalidCrudEntityException $e) {
                $this->addFlash('error', 'An error occurred while trying to update the user.');
            }
        }

        return $this->render('admin/pages/users/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}