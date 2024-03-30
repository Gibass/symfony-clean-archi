<?php

namespace App\Tests\Unit\Article;

use App\Domain\Article\Entity\ArticleInterface;
use PHPUnit\Framework\MockObject\MockObject;

readonly class ArticleTestDetails
{
    public function __construct(
        private ?int $id,
        private ?array $data,
        private ?string $response,
        private ?string $exception = null,
        private ?string $exceptionMessage = null
    ) {
    }

    public static function create(int $id, array $data = [], string $exception = null, string $exceptionMessage = null): static
    {
        $response = self::createResponse($id, $data);

        return new self($id, $data, $response, $exception, $exceptionMessage);
    }

    public function generateMockArticle(ArticleInterface&MockObject $article): null|ArticleInterface|MockObject
    {
        if ($this->id === 0) {
            return null;
        }

        $article->method('getId')->willReturn($this->id);
        $article->method('getTitle')->willReturn('Title-' . $this->id);
        $article->method('getSlug')->willReturn('title-' . $this->id);

        foreach ($this->data['fields'] ?? [] as $field => $value) {
            $method = 'get' . ucfirst($field);
            if (method_exists($article, $method)) {
                $article->method($method)->willReturn($value);
            }
        }

        return $article;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }

    public function getException(): ?string
    {
        return $this->exception;
    }

    public function getExceptionMessage(): ?string
    {
        return $this->exceptionMessage;
    }

    private static function createResponse(int $id, array $data): string
    {
        $response = 'Article id: ' . $id . ', ' .
            'url: title-' . $id . ', ' .
            'title : Title-' . $id . ', ' .
            'Content: ' . ($data['fields']['content'] ?? '');

        if (!empty($data['relations']['getCategory'])) {
            $response .= ', Category: ' . $data['relations']['getCategory']->getFields('title');
        }

        if (!empty($data['relations']['getTags'])) {
            $response .= ', Tags: ' . implode(',', array_map(function (array $tag) {
                return $tag['title'];
            }, $data['tags']));
        }

        return $response;
    }

    public function hasRelations(): bool
    {
        return !empty($this->data['relations']);
    }

    public function getRelations(): array
    {
        return $this->data['relations'] ?? [];
    }
}
