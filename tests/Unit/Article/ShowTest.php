<?php

namespace App\Tests\Unit\Article;

use App\Domain\Article\Entity\Article;
use App\Domain\Article\Entity\Image;
use App\Domain\Article\Exception\ArticleNotFoundException;
use App\Domain\Article\Gateway\ArticleGatewayInterface;
use App\Domain\Article\Presenter\ShowPresenterInterface;
use App\Domain\Article\Request\ShowRequest;
use App\Domain\Article\Response\ShowResponse;
use App\Domain\Article\UseCase\Show;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ShowTest extends TestCase
{
    private Show $useCase;

    /**
     * @var ShowPresenterInterface
     */
    private $presenter;

    private ArticleGatewayInterface&MockObject $gateway;

    protected function setUp(): void
    {
        $this->gateway = $this->createMock(ArticleGatewayInterface::class);

        $this->presenter = new class() implements ShowPresenterInterface {
            public function present(ShowResponse $response): string
            {
                return ShowTest::present($response);
            }
        };

        $this->useCase = new Show($this->gateway);
    }

    /**
     * @dataProvider dataSuccessfulProvider
     */
    public function testSuccessful(int $id, Article $article, string $viewResponse): void
    {
        $request = new ShowRequest($id);

        $this->gateway->method('getPublishedById')->with($id)->willReturn($article);

        $response = $this->useCase->execute($request, $this->presenter);
        $this->assertSame($viewResponse, $response);
    }

    /**
     * @dataProvider dataFailedProvider
     */
    public function testFailed(int $id, ?Article $article, string $exception, string $message): void
    {
        $request = new ShowRequest($id);

        $this->expectException($exception);
        $this->expectExceptionMessage($message);

        $this->gateway->method('getPublishedById')->with($id)->willReturn($article);
        $this->useCase->execute($request, $this->presenter);
    }

    public static function dataSuccessfulProvider(): \Generator
    {
        yield 'show_existing_article_with_title_and_content' => [
            'id' => 1,
            'article' => (new Article())
                ->setId(1)
                ->setSlug('title-1')
                ->setTitle('Title 1')
                ->setContent('The main Content')
                ->setMainMedia((new Image())->setTitle('Image 1'))
                ->setCreatedAt(\DateTimeImmutable::createFromFormat('d/m/Y', '25/04/2023')),
            'viewResponse' => self::generateArticleViewResponse(1, 'The main Content', '25-04-2023'),
        ];

        yield 'show_existing_article_with_no_content' => [
            'id' => 2,
            'article' => (new Article())
                ->setId(2)
                ->setSlug('title-2')
                ->setTitle('Title 2')
                ->setCreatedAt(\DateTimeImmutable::createFromFormat('d/m/Y', '15/02/2023')),
            'viewResponse' => self::generateArticleViewResponse(2, '', '15-02-2023', false),
        ];
    }

    public static function dataFailedProvider(): \Generator
    {
        yield 'load_non_existing_article' => [
            'id' => 3,
            'article' => null,
            'exception' => ArticleNotFoundException::class,
            'message' => 'Article with id : 3 not found',
        ];
    }

    public static function present(ShowResponse $response): string
    {
        $val = 'Article id: ' . $response->getArticle()->getId() . ', ' .
            'url: ' . $response->getArticle()->getSlug() . ', ' .
            'title : ' . $response->getArticle()->getTitle() . ', ' .
            'Content: ' . $response->getArticle()->getContent() . ', ' .
            'Created At: ' . $response->getArticle()->getCreatedAt()->format('d-m-Y');

        if ($response->getArticle()->getMainMedia()) {
            $val .= sprintf(', Media : %s', $response->getArticle()->getMainMedia()->getTitle());
        }

        return $val;
    }

    private static function generateArticleViewResponse(int $id, string $content, string $date, bool $media = true): string
    {
        $val = "Article id: $id, url: title-$id, title : Title $id, Content: $content, Created At: $date";

        if ($media) {
            $val .= ", Media : Image $id";
        }

        return $val;
    }
}
