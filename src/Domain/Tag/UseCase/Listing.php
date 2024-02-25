<?php

namespace App\Domain\Tag\UseCase;

use App\Domain\Tag\Exception\TagNotFoundException;
use App\Domain\Tag\Gateway\TagGatewayInterface;
use App\Domain\Tag\Presenter\ListingPresenterInterface;
use App\Domain\Tag\Request\ListingRequest;
use App\Domain\Tag\Response\ListingResponse;

readonly class Listing
{
    public function __construct(private TagGatewayInterface $tagGateway)
    {
    }

    /**
     * @throws TagNotFoundException
     */
    public function execute(ListingRequest $request, ListingPresenterInterface $presenter): mixed
    {
        $tag = $this->tagGateway->getBySlug($request->getSlug());

        if (!$tag) {
            throw new TagNotFoundException(sprintf('The Tag with slug %s does not exist', $request->getSlug()));
        }

        $adapter = $this->tagGateway->getPaginatedAdapter($tag);

        return $presenter->present(new ListingResponse($adapter, $tag, $request->getPage(), 10));
    }
}
