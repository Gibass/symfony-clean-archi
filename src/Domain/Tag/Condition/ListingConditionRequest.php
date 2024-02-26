<?php

namespace App\Domain\Tag\Condition;

use App\Domain\Article\Entity\Tag;
use App\Domain\Shared\Listing\Condition\ConditionRequestInterface;
use App\Domain\Tag\Exception\TagNotFoundException;
use App\Domain\Tag\Request\ListingRequest;

readonly class ListingConditionRequest implements ConditionRequestInterface
{
    public function __construct(private ListingRequest $request, private ?Tag $tag)
    {
    }

    public function isValid(): bool
    {
        return $this->tag !== null;
    }

    public function getGatewayCondition(): array
    {
        return ['id' => $this->tag->getId(), 'slug' => $this->tag->getSlug()];
    }

    public function getExceptionError(): \Exception
    {
        return new TagNotFoundException(sprintf('The Tag with slug %s does not exist', $this->request->getSLug()));
    }
}
