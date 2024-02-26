<?php

namespace App\Domain\Shared\Listing\Condition;

interface ConditionRequestInterface
{
    public function isValid(): bool;

    public function getGatewayCondition(): array;

    /**
     * @throws \Exception
     */
    public function getExceptionError(): \Exception;
}
