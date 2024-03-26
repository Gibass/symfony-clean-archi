<?php

namespace App\UserInterface\Controller\Admin\Security;

use App\Domain\Security\Request\UserVerifyRequest;
use App\Domain\Security\UseCase\UserVerify;
use App\UserInterface\Presenter\Web\Admin\UserVerifyPresenterHTML;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class VerificationController extends AbstractController
{
    #[Route('/user/verify/{token}', name: 'user_verify')]
    public function verify($token, UserVerify $userVerify, UserVerifyPresenterHTML $presenter): Response
    {
        return $userVerify->execute(new UserVerifyRequest($token), $presenter);
    }

    #[Route('/user/not-verified', name: 'user_not_verified')]
    public function notVerified(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('admin/pages/security/not-verified.html.twig', [
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }
}
