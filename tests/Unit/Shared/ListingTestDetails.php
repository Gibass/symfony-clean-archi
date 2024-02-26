<?php

namespace App\Tests\Unit\Shared;

use App\Domain\Shared\Listing\Action\ListingInterface;
use App\Domain\Shared\Listing\Request\ListingRequestInterface;
use PHPUnit\Framework\MockObject\MockObject;

class ListingTestDetails
{
    private ?ListingInterface $listing = null;

    public function __construct(
        private readonly ListingRequestInterface $request,
        private readonly string $listingClass,
        private readonly string $gatewayClass,
        private readonly string $responseClass,
        private readonly array $condition = [],
        private readonly array $exception = []
    ) {
    }

    public static function create(ListingRequestInterface $request, array $options): self
    {
        if (empty($options['listingClass']) || empty($options['gatewayClass']) || empty($options['responseClass'])) {
            throw new \InvalidArgumentException('Missing options to create ListingTestDetails');
        }

        return new self(
            $request,
            $options['listingClass'],
            $options['gatewayClass'],
            $options['responseClass'],
            $options['condition'] ?? [],
            $options['exception'] ?? []
        );
    }

    public function getRequest(): ListingRequestInterface
    {
        return $this->request;
    }

    public function getListing(MockObject $gateway): ListingInterface
    {
        if (!$this->listing) {
            $this->listing = new ($this->listingClass)($gateway);
        }

        return $this->listing;
    }

    public function getGatewayClass(): string
    {
        return $this->gatewayClass;
    }

    public function getResponseClass(): string
    {
        return $this->responseClass;
    }

    public function hasCondition(): bool
    {
        return !empty($this->condition);
    }

    public function getConditionMethod(): string
    {
        return $this->condition['method'] ?? '';
    }

    public function getConditionArgs(): string
    {
        return $this->condition['args'] ?? '';
    }

    public function getConditionReturn(): mixed
    {
        return $this->condition['return'] ?? null;
    }

    public function getExceptionClass(): string
    {
        return $this->exception['class'] ?? '';
    }

    public function getExceptionMessage(): string
    {
        return $this->exception['message'] ?? '';
    }
}
