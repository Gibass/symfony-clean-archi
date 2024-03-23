<?php

namespace App\UserInterface\Controller\Admin\Security;

use App\Domain\Security\Exception\EmailAlreadyExistException;
use App\Domain\Security\Request\RegistrationRequest;
use App\Domain\Security\UseCase\Registration;
use App\UserInterface\DTO\RegistrationDTO;
use App\UserInterface\Form\RegistrationType;
use App\UserInterface\Presenter\Web\RegisterPresenterHTML;
use Assert\AssertionFailedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class RegisterController extends AbstractController
{
    #[Route('/register', name: 'admin_register')]
    public function register(Request $request, Registration $registration, RegisterPresenterHTML $presenter): Response
    {
        $user = new RegistrationDTO();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $registrationRequest = new RegistrationRequest($user->getEmail(), $user->getPlainPassword(), $user->getPlainPassword());

            try {
                if ($registration->execute($registrationRequest)) {
                    return $this->redirectToRoute('admin_register_success');
                }
            } catch (EmailAlreadyExistException|AssertionFailedException $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $presenter->present($form);
    }

    #[Route('/register/success', name: 'admin_register_success')]
    public function registerSuccess(): Response
    {
        return $this->render('admin/pages/security/register-success.html.twig');
    }
}
