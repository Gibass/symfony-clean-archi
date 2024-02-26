<?php

namespace App\Tests\Unit\Article;

use App\Domain\Article\Entity\Category;
use App\Domain\Article\Entity\Tag;
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
    public function testSuccessful(ArticleTestDetails $details): void
    {
        $request = new ShowRequest($details->getId());

        $this->gateway->method('getPublishedById')->with($details->getId())->willReturn($details->getArticle());

        $response = $this->useCase->execute($request, $this->presenter);
        $this->assertSame($details->getResponse(), $response);
    }

    /**
     * @dataProvider dataFailedProvider
     */
    public function testFailed(ArticleTestDetails $details): void
    {
        $request = new ShowRequest($details->getId());

        $this->expectException($details->getException());
        $this->expectExceptionMessage($details->getExceptionMessage());

        $this->gateway->method('getPublishedById')->with($details->getId())->willReturn($details->getArticle());
        $this->useCase->execute($request, $this->presenter);
    }

    public static function dataSuccessfulProvider(): \Generator
    {
        yield 'show_existing_complete_article_with_title_and_content' => [ArticleTestDetails::create(1, [
            'category' => new Category('Men', 'men'),
            'tags' => [new Tag('Photo', 'photo'), new Tag('Image', 'image')],
            'content' => 'The main Content',
            'createdAt' => new \DateTime('25-04-2023'),
        ])];

        yield 'show_existing_article_with_no_content' => [ArticleTestDetails::create(2, [
            'category' => new Category('Men', 'men'),
            'tags' => [new Tag('Photo', 'photo')],
            'createdAt' => new \DateTime('25-04-2023'),
        ])];

        yield 'show_existing_article_with_no_tag' => [ArticleTestDetails::create(3, [
            'category' => new Category('Men', 'men'),
            'content' => 'The main Content',
            'createdAt' => new \DateTime('25-04-2023'),
        ])];

        yield 'show_existing_article_with_no_category' => [ArticleTestDetails::create(4, [
            'tags' => [new Tag('Photo', 'photo')],
            'content' => 'The main Content',
            'createdAt' => new \DateTime('25-04-2023'),
        ])];

        yield 'show_existing_article_with_no_taxonomy' => [ArticleTestDetails::create(4, [
            'content' => 'The main Content',
            'createdAt' => new \DateTime('25-04-2023'),
        ])];
    }

    public static function dataFailedProvider(): \Generator
    {
        yield 'load_non_existing_article' => [ArticleTestDetails::create(
            3,
            [],
            ArticleNotFoundException::class,
            'Article with id : 3 not found'
        )];
    }

    public static function present(ShowResponse $response): string
    {
        $val = 'Article id: ' . $response->getArticle()->getId() . ', ' .
            'url: ' . $response->getArticle()->getSlug() . ', ' .
            'title : ' . $response->getArticle()->getTitle() . ', ' .
            'Content: ' . $response->getArticle()->getContent() . ', ' .
            'Created At: ' . $response->getArticle()->getCreatedAt()->format('d-m-Y');

        if ($category = $response->getArticle()->getCategory()) {
            $val .= ', Category: ' . $category->getTitle();
        }

        if ($response->getArticle()->getTags()) {
            $val .= ', Tags: ' . implode(',', array_map(function (Tag $tag) {
                return $tag->getTitle();
            }, $response->getArticle()->getTags()));
        }

        if ($response->getArticle()->getMainMedia()) {
            $val .= sprintf(', Media : %s', $response->getArticle()->getMainMedia()->getTitle());
        }

        return $val;
    }
}
