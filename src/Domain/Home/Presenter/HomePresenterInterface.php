<?php

namespace App\Domain\Home\Presenter;

use App\Domain\Home\Response\HomeResponse;

interface HomePresenterInterface
{
    public function present(HomeResponse $response): mixed;
}
