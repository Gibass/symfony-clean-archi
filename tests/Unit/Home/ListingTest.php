<?php

namespace App\Tests\Unit\Home;

use App\Domain\Article\Gateway\ArticleGatewayInterface;
use App\Domain\Home\Presenter\ListingPresenterInterface;
use App\Domain\Home\Request\ListingRequest;
use App\Domain\Home\Response\ListingResponse;
use App\Domain\Home\UseCase\Listing;
use Pagerfanta\Adapter\AdapterInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ListingTest extends TestCase
{
    private Listing $useCase;

    /**
     * @var ListingPresenterInterface
     */
    private $presenter;

    private MockObject&ArticleGatewayInterface $gateway;

    protected function setUp(): void
    {
        $this->gateway = $this->createMock(ArticleGatewayInterface::class);

        $this->presenter = new class() implements ListingPresenterInterface {
            public function present(ListingResponse $response): ListingResponse
            {
                return $response;
            }
        };

        $this->useCase = new Listing($this->gateway);
    }

    public function testSuccessful(): void
    {
        $request = new ListingRequest();

        $adapter = $this->createMock(AdapterInterface::class);
        $adapter->method('getNbResults')->willReturn(3);

        $this->gateway->method('getPaginatedAdapter')->willReturn($adapter);

        $response = $this->useCase->execute($request, $this->presenter);

        $this->assertSame(3, $response->getAdapter()->getNbResults());
    }
}
