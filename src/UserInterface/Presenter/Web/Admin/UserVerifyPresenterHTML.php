<?php

namespace App\UserInterface\Presenter\Web\Admin;

use App\Domain\Security\Exception\EmailNotFoundException;
use App\Domain\Security\Exception\ExpiredTokenException;
use App\Domain\Security\Exception\InvalidTokenException;
use App\Domain\Security\Presenter\UserVerifyPresenterInterface;
use App\Domain\Security\Response\UserVerifyResponse;
use App\UserInterface\Presenter\Web\AbstractWebPresenter;
use Symfony\Component\HttpFoundation\Response;

class UserVerifyPresenterHTML extends AbstractWebPresenter implements UserVerifyPresenterInterface
{
    public function present(UserVerifyResponse $response): Response
    {
        $message = match ($response->getInvalidCode()) {
            ExpiredTokenException::INVALID_CODE => 'The verification link is expired',
            InvalidTokenException::INVALID_CODE => 'Your link is invalid',
            EmailNotFoundException::INVALID_CODE => 'User no longer exists',
            default => null,
        };

        return $this->render('admin/pages/security/user-verify.html.twig', [
            'isValid' => !$response->getInvalidCode(),
            'message' => $message,
        ]);
    }
}
