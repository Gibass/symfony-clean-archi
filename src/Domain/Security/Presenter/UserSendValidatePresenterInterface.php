<?php

namespace App\Domain\Security\Presenter;

use App\Domain\Security\Response\UserSendValidateResponse;

interface UserSendValidatePresenterInterface
{
    public function present(UserSendValidateResponse $response): mixed;
}
