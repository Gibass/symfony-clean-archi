<?php

namespace App\Tests\Unit\Article;

use App\Domain\Article\Entity\ArticleInterface;
use App\Domain\Article\Entity\TaxonomyInterface;
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

        $article = $details->generateMockArticle($this->createMock(ArticleInterface::class));
        $this->gateway->method('getPublishedById')->with($details->getId())->willReturn($article);

        if ($details->hasRelations()) {
            foreach ($details->getRelations() as $method => $relation) {
                $mock = $relation->generateMockRelation($this->createMock($relation->getClass()));
                $article->method($method)->willReturn($mock);
            }
        }

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

        $article = $details->generateMockArticle($this->createMock(ArticleInterface::class));
        $this->gateway->method('getPublishedById')->with($details->getId())->willReturn($article);
        $this->useCase->execute($request, $this->presenter);
    }

    public static function dataSuccessfulProvider(): \Generator
    {
        yield 'show_existing_complete_article_with_title_and_content' => [ArticleTestDetails::create(1, [
            'relations' => [
                'getCategory' => TaxonomyTestDetails::create(1, ['fields' => ['title' => 'Men']]),
            ],
            // 'tags' => [new TagInterface('Photo', 'photo'), new TagInterface('Image', 'image')],
            'fields' => [
                'content' => 'The main Content',
            ],
        ])];

        yield 'show_existing_article_with_no_content' => [ArticleTestDetails::create(2, [
            // 'category' => new CategoryInterface('Men', 'men'),
            // 'tags' => [new TagInterface('Photo', 'photo')],
        ])];

        yield 'show_existing_article_with_no_tag' => [ArticleTestDetails::create(3, [
            // 'category' => new CategoryInterface('Men', 'men'),
            'fields' => [
                'content' => 'The main Content',
            ],
        ])];

        yield 'show_existing_article_with_no_category' => [ArticleTestDetails::create(4, [
            // 'tags' => [new TagInterface('Photo', 'photo')],
            'fields' => [
                'content' => 'The main Content',
            ],
        ])];

        yield 'show_existing_article_with_no_taxonomy' => [ArticleTestDetails::create(4, [
            'fields' => [
                'content' => 'The main Content',
            ],
        ])];
    }

    public static function dataFailedProvider(): \Generator
    {
        yield 'load_non_existing_article' => [ArticleTestDetails::create(
            0,
            [],
            ArticleNotFoundException::class,
            'Article with id : 0 not found'
        )];
    }

    public static function present(ShowResponse $response): string
    {
        $val = 'Article id: ' . $response->getArticle()->getId() . ', ' .
            'url: ' . $response->getArticle()->getSlug() . ', ' .
            'title : ' . $response->getArticle()->getTitle() . ', ' .
            'Content: ' . $response->getArticle()->getContent();

        if ($category = $response->getArticle()->getCategory()) {
            $val .= ', Category: ' . $category->getTitle();
        }

        if ($response->getArticle()->getTags()) {
            $val .= ', Tags: ' . implode(',', array_map(function (TaxonomyInterface $tag) {
                return $tag->getTitle();
            }, $response->getArticle()->getTags()));
        }

        return $val;
    }
}
