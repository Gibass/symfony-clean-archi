<?php

namespace App\Domain\Home\Presenter;

use App\Domain\Home\Response\ListingResponse;

interface ListingPresenterInterface
{
    public function present(ListingResponse $response): mixed;
}
