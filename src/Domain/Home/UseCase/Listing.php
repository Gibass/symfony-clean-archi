<?php

namespace App\Domain\Home\UseCase;

use App\Domain\Article\Gateway\ArticleGatewayInterface;
use App\Domain\Home\Presenter\ListingPresenterInterface;
use App\Domain\Home\Request\ListingRequest;
use App\Domain\Home\Response\ListingResponse;

readonly class Listing
{
    public function __construct(private ArticleGatewayInterface $articleGateway)
    {
    }

    public function execute(ListingRequest $request, ListingPresenterInterface $presenter): mixed
    {
        $adapter = $this->articleGateway->getPaginatedAdapter();

        return $presenter->present(new ListingResponse($adapter, $request->getPage(), 10));
    }
}
