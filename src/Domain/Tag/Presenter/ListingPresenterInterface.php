<?php

namespace App\Domain\Tag\Presenter;

use App\Domain\Tag\Response\ListingResponse;

interface ListingPresenterInterface
{
    public function present(ListingResponse $response): mixed;
}
