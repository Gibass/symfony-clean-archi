<?php

namespace App\Domain\Shared\Listing\UseCase;

use App\Domain\Shared\Listing\Action\ListingInterface;
use App\Domain\Shared\Listing\Presenter\ListingPresenterInterface;
use App\Domain\Shared\Listing\Request\ListingRequestInterface;

readonly class ListingUseCase
{
    /**
     * @throws \Exception
     */
    public function execute(ListingRequestInterface $request, ListingInterface $listing, ListingPresenterInterface $presenter): mixed
    {
        $condition = $listing->getRequestCondition($request);

        if (!$condition->isValid()) {
            throw $condition->getExceptionError();
        }

        $adapter = $listing->getListingGateway()->getPaginatedAdapter($condition->getGatewayCondition());

        return $presenter->present($listing->createResponse($adapter, $request));
    }
}
