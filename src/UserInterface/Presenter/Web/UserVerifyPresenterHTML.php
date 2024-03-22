<?php

namespace App\UserInterface\Presenter\Web;

use App\Domain\Security\Exception\ExpiredTokenException;
use App\Domain\Security\Exception\InvalidTokenException;
use App\Domain\Security\Presenter\UserVerifyPresenterInterface;
use App\Domain\Security\Response\UserVerifyResponse;
use Symfony\Component\HttpFoundation\Response;

class UserVerifyPresenterHTML extends AbstractWebPresenter implements UserVerifyPresenterInterface
{
    public function present(UserVerifyResponse $response): Response
    {
        $message = match ($response->getInvalidCode()) {
            ExpiredTokenException::INVALID_CODE => 'The verification link is expired',
            InvalidTokenException::INVALID_CODE => 'Your Link is invalid',
            default => null,
        };

        return $this->render('admin/pages/security/user-verify.html.twig', [
            'isValid' => !$response->getInvalidCode(),
            'message' => $message,
        ]);
    }
}
