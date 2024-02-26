<?php

namespace App\Domain\Category\Condition;

use App\Domain\Article\Entity\Category;
use App\Domain\Category\Exception\CategoryNotFoundException;
use App\Domain\Category\Request\ListingRequest;
use App\Domain\Shared\Listing\Condition\ConditionRequestInterface;

readonly class ListingConditionRequest implements ConditionRequestInterface
{
    public function __construct(private ListingRequest $request, private ?Category $category)
    {
    }

    public function isValid(): bool
    {
        return $this->category !== null;
    }

    public function getGatewayCondition(): array
    {
        return ['id' => $this->category->getId(), 'slug' => $this->category->getSlug()];
    }

    public function getExceptionError(): \Exception
    {
        return new CategoryNotFoundException(sprintf('The Category with slug %s does not exist', $this->request->getSLug()));
    }
}
