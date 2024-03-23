<?php

namespace App\Domain\Security\UseCase;

use App\Domain\Security\Presenter\UserSendValidatePresenterInterface;
use App\Domain\Security\Request\UserSendValidateRequest;
use App\Domain\Security\Response\UserSendValidateResponse;
use App\Domain\Shared\Helper\TokenHelperInterface;
use App\Domain\Shared\Mailer\MailerInterface;

readonly class UserSendValidate
{
    public function __construct(private MailerInterface $mailer, private TokenHelperInterface $tokenHelper)
    {
    }

    public function execute(UserSendValidateRequest $request, UserSendValidatePresenterInterface $presenter): void
    {
        $user = $request->getUser();
        $response = new UserSendValidateResponse($user, $this->tokenHelper->generateUserToken($user));

        $this->mailer->sendMail($presenter->present($response));
    }
}
