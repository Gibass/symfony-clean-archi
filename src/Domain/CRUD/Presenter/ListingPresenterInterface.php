<?php

namespace App\Domain\CRUD\Presenter;

use App\Domain\CRUD\Response\ListingResponse;

interface ListingPresenterInterface
{
    public function present(ListingResponse $response): mixed;
}
