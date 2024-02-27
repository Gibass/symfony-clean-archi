<?php

namespace Unit\Category;

use App\Domain\Article\Entity\Category;
use App\Domain\Article\Entity\Tag;
use App\Domain\Article\Gateway\ArticleGatewayInterface;
use App\Domain\Category\Exception\CategoryNotFoundException;
use App\Domain\Category\Gateway\CategoryGatewayInterface;
use App\Domain\Tag\Exception\TagNotFoundException;
use App\Domain\Tag\Gateway\TagGatewayInterface;
use App\Domain\Category\Presenter\CategoryShowPresenterInterface;
use App\Domain\Category\Request\CategoryShowRequest;
use App\Domain\Category\Response\CategoryShowResponse;
use App\Domain\Category\UseCase\CategoryShow;
use Pagerfanta\Adapter\AdapterInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CategoryShowTest extends TestCase
{
    private ArticleGatewayInterface&MockObject $articleGateway;
    private CategoryGatewayInterface&MockObject $categoryGateway;
    private TagGatewayInterface&MockObject $tageGateway;
    private CategoryShowPresenterInterface $presenter;
    private CategoryShow $useCase;

    protected function setUp(): void
    {
        $this->articleGateway = $this->createMock(ArticleGatewayInterface::class);
        $this->categoryGateway = $this->createMock(CategoryGatewayInterface::class);
        $this->tageGateway = $this->createMock(TagGatewayInterface::class);

        $this->presenter = new class() implements CategoryShowPresenterInterface {
            public function present(CategoryShowResponse $response): CategoryShowResponse
            {
                return $response;
            }
        };

        $this->useCase = new CategoryShow($this->articleGateway, $this->categoryGateway, $this->tageGateway);
    }

    public function testCategoryShowSuccessful(): void
    {
        $request = new CategoryShowRequest('men');

        $adapter = $this->createMock(AdapterInterface::class);
        $adapter->method('getNbResults')->willReturn(10);

        $this->articleGateway->method('getLastArticles')->willReturn(range(1, 3));
        $this->categoryGateway->method('getFacetCategories')->willReturn(range(1, 5));
        $this->categoryGateway->method('getPaginatedAdapter')->willReturn($adapter);
        $this->categoryGateway->method('getBySlug')->willReturn(new Category('Men', 'men'));
        $this->tageGateway->method('getPopularTag')->willReturn(range(1, 10));

        $response = $this->useCase->execute($request, $this->presenter);

        $this->assertInstanceOf(CategoryShowResponse::class, $response);
        $this->assertSame(10, $response->getAdapter()->getNbResults());
        $this->assertCount(5, $response->getCategories());
        $this->assertCount(10, $response->getTags());
        $this->assertCount(3, $response->getLastArticles());
    }

    public function testCategoryShowFailed(): void
    {
        $this->categoryGateway->method('getBySlug')->willReturn(null);

        $this->expectException(CategoryNotFoundException::class);
        $this->expectExceptionMessage('The Category with slug photo does not exist');

        $this->useCase->execute(new CategoryShowRequest('photo'), $this->presenter);
    }
}
