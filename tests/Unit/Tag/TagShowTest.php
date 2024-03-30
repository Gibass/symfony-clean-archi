<?php

namespace Unit\Tag;

use App\Domain\Article\Entity\TagInterface;
use App\Domain\Article\Entity\TaxonomyInterface;
use App\Domain\Article\Gateway\ArticleGatewayInterface;
use App\Domain\Category\Gateway\CategoryGatewayInterface;
use App\Domain\Tag\Exception\TagNotFoundException;
use App\Domain\Tag\Gateway\TagGatewayInterface;
use App\Domain\Tag\Presenter\TagShowPresenterInterface;
use App\Domain\Tag\Request\TagShowRequest;
use App\Domain\Tag\Response\TagShowResponse;
use App\Domain\Tag\UseCase\TagShow;
use Pagerfanta\Adapter\AdapterInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TagShowTest extends TestCase
{
    private ArticleGatewayInterface&MockObject $articleGateway;
    private CategoryGatewayInterface&MockObject $categoryGateway;
    private TagGatewayInterface&MockObject $tageGateway;
    private TagShowPresenterInterface $presenter;
    private TagShow $useCase;

    protected function setUp(): void
    {
        $this->articleGateway = $this->createMock(ArticleGatewayInterface::class);
        $this->categoryGateway = $this->createMock(CategoryGatewayInterface::class);
        $this->tageGateway = $this->createMock(TagGatewayInterface::class);

        $this->presenter = new class() implements TagShowPresenterInterface {
            public function present(TagShowResponse $response): TagShowResponse
            {
                return $response;
            }
        };

        $this->useCase = new TagShow($this->articleGateway, $this->categoryGateway, $this->tageGateway);
    }

    public function testTagShowSuccessful(): void
    {
        $request = new TagShowRequest('photo');

        $adapter = $this->createMock(AdapterInterface::class);
        $adapter->method('getNbResults')->willReturn(10);

        $tag = $this->createMock(TaxonomyInterface::class);

        $this->articleGateway->method('getLastArticles')->willReturn(range(1, 3));
        $this->categoryGateway->method('getFacetCategories')->willReturn(range(1, 5));
        $this->tageGateway->method('getPaginatedAdapter')->willReturn($adapter);
        $this->tageGateway->method('getPopularTag')->willReturn(range(1, 10));
        $this->tageGateway->method('getBySlug')->willReturn($tag);

        $response = $this->useCase->execute($request, $this->presenter);

        $this->assertInstanceOf(TagShowResponse::class, $response);
        $this->assertSame(10, $response->getAdapter()->getNbResults());
        $this->assertCount(5, $response->getCategories());
        $this->assertCount(10, $response->getTags());
        $this->assertCount(3, $response->getLastArticles());
    }

    public function testTagShowFailed(): void
    {
        $this->tageGateway->method('getBySlug')->willReturn(null);

        $this->expectException(TagNotFoundException::class);
        $this->expectExceptionMessage('The Tag with slug photo does not exist');

        $this->useCase->execute(new TagShowRequest('photo'), $this->presenter);
    }
}
