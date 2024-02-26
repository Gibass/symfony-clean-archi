<?php

namespace App\Tests\Unit\Article;

use App\Domain\Article\Entity\Article;
use App\Domain\Article\Entity\Tag;

readonly class ArticleTestDetails
{
    public function __construct(
        private ?int $id,
        private ?Article $article,
        private ?string $response,
        private ?string $exception = null,
        private ?string $exceptionMessage = null
    ) {
    }

    public static function create(int $id, array $data = [], string $exception = null, string $exceptionMessage = null): static
    {
        $article = $response = null;
        if ($data) {
            $article = self::createArticle($id, $data);
            $response = self::createResponse($id, $data);
        }

        return new self($id, $article, $response, $exception, $exceptionMessage);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
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

    private static function createArticle(int $id, array $data): Article
    {
        $article = (new Article())
            ->setId($id)
            ->setTitle('Title-' . $id)
            ->setSlug('title-' . $id)
        ;

        if (!empty($data['tags'])) {
            $article->addTags($data['tags']);
        }

        if (!empty($data['category'])) {
            $article->setCategory($data['category']);
        }

        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($article, $method)) {
                $article->$method($value);
            }
        }

        return $article;
    }

    private static function createResponse(int $id, array $data): string
    {
        $response = 'Article id: ' . $id . ', ' .
            'url: title-' . $id . ', ' .
            'title : Title-' . $id . ', ' .
            'Content: ' . ($data['content'] ?? '') . ', ' .
            'Created At: ' . (!empty($data['createdAt']) ? $data['createdAt']->format('d-m-Y') : '');

        if (!empty($data['category'])) {
            $response .= ', Category: ' . $data['category']->getTitle();
        }

        if (!empty($data['tags'])) {
            $response .= ', Tags: ' . implode(',', array_map(function (Tag $tag) {
                return $tag->getTitle();
            }, $data['tags']));
        }

        return $response;
    }
}
