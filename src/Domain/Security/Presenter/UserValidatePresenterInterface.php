<?php

namespace App\Domain\Security\Presenter;

use App\Domain\Security\Response\UserValidateResponse;

interface UserValidatePresenterInterface
{
    public function present(UserValidateResponse $response): mixed;
}