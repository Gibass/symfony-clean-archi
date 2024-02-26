<?php

namespace App\Domain\Category\Presenter;

use App\Domain\Category\Response\ListingResponse;

interface ListingPresenterInterface
{
    public function present(ListingResponse $response): mixed;
}
