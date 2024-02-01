<?php

namespace App\Tests\Unit\Article;

use App\Domain\Article\Entity\Article;
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
                return 'Article id: ' . $response->getArticle()->id . ', ' .
                    'url: ' . $response->getArticle()->getSlug() . ', ' .
                    'title : ' . $response->getArticle()->getTitle() . ', ' .
                    'Content: ' . $response->getArticle()->getContent();
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

        $this->gateway->method('getById')->with($id)->willReturn($article);

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

        $this->gateway->method('getById')->with($id)->willReturn($article);
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
                ->setContent('The main Content'),
            'viewResponse' => 'Article id: 1, url: title-1, title : Title 1, Content: The main Content',
        ];

        yield 'show_existing_article_with_no_content' => [
            'id' => 2,
            'article' => (new Article())
                ->setId(2)
                ->setSlug('title-2')
                ->setTitle('Title 2'),
            'viewResponse' => 'Article id: 2, url: title-2, title : Title 2, Content: ',
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
}
