<?php

namespace App\Domain\Home\Condition;

use App\Domain\Shared\Listing\Condition\ConditionRequestInterface;

readonly class ListingConditionRequest implements ConditionRequestInterface
{
    public function isValid(): bool
    {
        return true;
    }

    public function getGatewayCondition(): array
    {
        return [];
    }

    public function getExceptionError(): \Exception
    {
        return new \Exception();
    }
}
