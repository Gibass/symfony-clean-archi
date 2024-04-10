<?php

namespace App\Tests\Common\CRUD;

abstract class CrudTestDetails
{
    public function __construct(
        private readonly string $url,
        private readonly array $values = [],
        private readonly array $assert = [])
    {
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function getSuccessMessage(): string
    {
        return $this->assert['success'] ?? '';
    }

    public function getErrorMessage(): string
    {
        return $this->assert['error'] ?? '';
    }

    public function getVerifyCount(): string
    {
        return $this->assert['verifyCount'] ?? '';
    }

    public function getVerifyElement(): string
    {
        return $this->assert['verifyElement'] ?? '';
    }

    public function getDefaultValues(): array
    {
        return $this->assert['defaultValues'] ?? [];
    }

    public function getResponseCode(): int
    {
        return $this->assert['responseCode'] ?? 0;
    }
}
