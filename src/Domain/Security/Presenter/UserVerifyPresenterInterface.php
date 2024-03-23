<?php

namespace App\Domain\Security\Presenter;

use App\Domain\Security\Response\UserVerifyResponse;

interface UserVerifyPresenterInterface
{
    public function present(UserVerifyResponse $response): mixed;
}
