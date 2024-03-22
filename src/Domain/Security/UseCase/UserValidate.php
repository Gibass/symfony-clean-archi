<?php

namespace App\Domain\Security\UseCase;

use App\Domain\Security\Presenter\UserValidatePresenterInterface;
use App\Domain\Security\Request\UserValidateRequest;
use App\Domain\Security\Response\UserValidateResponse;
use App\Domain\Shared\Mailer\MailerInterface;

readonly class UserValidate
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function execute(UserValidateRequest $request, UserValidatePresenterInterface $presenter): void
    {
        $response = new UserValidateResponse($request->getUser());

        $this->mailer->sendMail($presenter->present($response));
    }
}
