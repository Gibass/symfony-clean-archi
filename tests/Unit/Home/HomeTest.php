<?php

namespace Unit\Home;

use App\Domain\Article\Gateway\ArticleGatewayInterface;
use App\Domain\Category\Gateway\CategoryGatewayInterface;
use App\Domain\Home\Presenter\HomePresenterInterface;
use App\Domain\Home\Request\HomeRequest;
use App\Domain\Home\Response\HomeResponse;
use App\Domain\Home\UseCase\Home;
use App\Domain\Tag\Gateway\TagGatewayInterface;
use Pagerfanta\Adapter\AdapterInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class HomeTest extends TestCase
{
    private ArticleGatewayInterface&MockObject $articleGateway;
    private CategoryGatewayInterface&MockObject $categoryGateway;
    private TagGatewayInterface&MockObject $tageGateway;
    private HomePresenterInterface $presenter;
    private Home $useCase;

    protected function setUp(): void
    {
        $this->articleGateway = $this->createMock(ArticleGatewayInterface::class);
        $this->categoryGateway = $this->createMock(CategoryGatewayInterface::class);
        $this->tageGateway = $this->createMock(TagGatewayInterface::class);

        $this->presenter = new class() implements HomePresenterInterface {
            public function present(HomeResponse $response): HomeResponse
            {
                return $response;
            }
        };

        $this->useCase = new Home($this->articleGateway, $this->categoryGateway, $this->tageGateway);
    }

    public function testHomeSuccessful(): void
    {
        $request = new HomeRequest();

        $adapter = $this->createMock(AdapterInterface::class);
        $adapter->method('getNbResults')->willReturn(10);

        $this->articleGateway->method('getPaginatedAdapter')->willReturn($adapter);
        $this->articleGateway->method('getLastArticles')->willReturn(range(1, 3));
        $this->categoryGateway->method('getFacetCategories')->willReturn(range(1, 5));
        $this->tageGateway->method('getPopularTag')->willReturn(range(1, 10));

        $response = $this->useCase->execute($request, $this->presenter);

        $this->assertInstanceOf(HomeResponse::class, $response);
        $this->assertSame(10, $response->getAdapter()->getNbResults());
        $this->assertCount(5, $response->getCategories());
        $this->assertCount(10, $response->getTags());
        $this->assertCount(3, $response->getLastArticles());
    }
}
