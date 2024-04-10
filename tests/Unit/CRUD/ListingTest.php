<?php

namespace Unit\CRUD;

use App\Domain\CRUD\Gateway\CrudGatewayInterface;
use App\Domain\CRUD\Presenter\ListingPresenterInterface;
use App\Domain\CRUD\Request\ListingRequest;
use App\Domain\CRUD\Response\ListingResponse;
use App\Domain\CRUD\UseCase\Listing;
use Pagerfanta\Adapter\AdapterInterface;
use PHPUnit\Framework\TestCase;

class ListingTest extends TestCase
{
    private Listing $useCase;

    private ListingPresenterInterface $presenter;

    protected function setUp(): void
    {
        $this->presenter = new class() implements ListingPresenterInterface {
            public function present(ListingResponse $response): ListingResponse
            {
                return $response;
            }
        };

        $this->useCase = new Listing();
    }

    public function testListingSuccessfully(): void
    {
        $request = new ListingRequest(['add' => 'create']);

        $adapter = $this->createMock(AdapterInterface::class);
        $adapter->method('getNbResults')->willReturn(50);

        $gateway = $this->createMock(CrudGatewayInterface::class);
        $gateway->method('getPaginatedAdapter')->willReturn($adapter);

        $response = $this->useCase->execute($request, $this->presenter, $gateway);

        $this->assertInstanceOf(ListingResponse::class, $response);
        $this->assertSame(50, $response->getAdapter()->getNbResults());
        $this->assertContains('create', $response->getRoutes());
    }
}
