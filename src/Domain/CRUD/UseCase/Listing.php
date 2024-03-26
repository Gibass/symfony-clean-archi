<?php

namespace App\Domain\CRUD\UseCase;

use App\Domain\CRUD\Gateway\CrudGatewayInterface;
use App\Domain\CRUD\Presenter\ListingPresenterInterface;
use App\Domain\CRUD\Request\ListingRequest;
use App\Domain\CRUD\Response\ListingResponse;

class Listing
{
    public function execute(ListingRequest $request, ListingPresenterInterface $presenter, CrudGatewayInterface $gateway): mixed
    {
        return $presenter->present(new ListingResponse(
            $request->getRoutes(),
            $gateway->getPaginatedAdapter(['type' => 'all']),
            $request->getCurrentPage(),
            50
        ));
    }
}
