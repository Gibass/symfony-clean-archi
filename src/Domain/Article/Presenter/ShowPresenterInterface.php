<?php

namespace App\Domain\Article\Presenter;

use App\Domain\Article\Response\ShowResponse;

interface ShowPresenterInterface
{
    public function present(ShowResponse $response): mixed;
}
