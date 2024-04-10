<?php

namespace App\Domain\Security\UseCase;

use App\Domain\Security\Exception\EmailNotFoundException;
use App\Domain\Security\Exception\ExpiredTokenException;
use App\Domain\Security\Exception\InvalidTokenException;
use App\Domain\Security\Gateway\UserGatewayInterface;
use App\Domain\Security\Presenter\UserVerifyPresenterInterface;
use App\Domain\Security\Request\UserVerifyRequest;
use App\Domain\Security\Response\UserVerifyResponse;
use App\Domain\Shared\Helper\TokenHelperInterface;

readonly class UserVerify
{
    public function __construct(private TokenHelperInterface $tokenHelper, private UserGatewayInterface $gateway)
    {
    }

    public function execute(UserVerifyRequest $request, UserVerifyPresenterInterface $presenter)
    {
        $token = $request->getToken();
        $response = new UserVerifyResponse();

        try {
            $payload = $this->tokenHelper->verifyToken($token);

            $user = $this->gateway->findByEmail($payload['user_email'] ?? '');
            if (!$user) {
                throw new EmailNotFoundException();
            }

            $this->gateway->validate($user);
        } catch (ExpiredTokenException | InvalidTokenException | EmailNotFoundException $e) {
            $response->setInvalidCode($e->getInvalidCode());
        }

        return $presenter->present($response);
    }
}
