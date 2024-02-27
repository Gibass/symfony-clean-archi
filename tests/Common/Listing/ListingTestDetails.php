<?php

namespace App\Tests\Common\Listing;

readonly class ListingTestDetails
{
    public function __construct(
        private string $url,
        private ?string $element,
        private ?int $count,
        private ?string $exception,
        private array $asserts = []
    ) {
    }

    public static function create(string $url, array $options = []): self
    {
        return new self(
            $url,
            $options['element'] ?? null,
            $options['count'] ?? null,
            $options['exception'] ?? null,
            $options['asserts'] ?? []
        );
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getElement(): string
    {
        return $this->element;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function hasAssert(): bool
    {
        return !empty($this->asserts);
    }

    public function getFistElementId(): string
    {
        return $this->asserts['firstId'] ?? '';
    }

    public function getFistSelector(): string
    {
        return $this->asserts['firstSelector'] ?? '.article-content article:nth-child(1)';
    }

    public function getLastElementId(): string
    {
        return $this->asserts['LastId'] ?? '';
    }

    public function getLastSelector(): string
    {
        return $this->asserts['lastSelector'] ?? '.article-content article:last-child';
    }

    public function getAttrSelector(): string
    {
        return $this->asserts['attrSelector'] ?? 'id';
    }

    public function getExceptionClass(): string
    {
        return $this->exception ?? '';
    }
}
