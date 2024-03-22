<?php

namespace App\Domain\Security\UseCase;

use App\Domain\Security\Exception\ExpiredTokenException;
use App\Domain\Security\Exception\InvalidTokenException;
use App\Domain\Security\Presenter\UserVerifyPresenterInterface;
use App\Domain\Security\Request\UserVerifyRequest;
use App\Domain\Security\Response\UserVerifyResponse;
use App\Domain\Shared\Helper\TokenHelperInterface;

readonly class UserVerify
{
    public function __construct(private TokenHelperInterface $tokenHelper)
    {
    }

    public function execute(UserVerifyRequest $request, UserVerifyPresenterInterface $presenter)
    {
        $token = $request->getToken();
        $response = new UserVerifyResponse($token);

        try {
            $this->tokenHelper->verifyToken($token);
        } catch (ExpiredTokenException | InvalidTokenException $e) {
            $response->setInvalidCode($e->getInvalidCode());
        }

        return $presenter->present($response);
    }
}
