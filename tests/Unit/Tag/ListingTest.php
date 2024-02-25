<?php

namespace App\Tests\Unit\Tag;

use App\Domain\Article\Entity\Tag;
use App\Domain\Tag\Gateway\TagGatewayInterface;
use App\Domain\Tag\Presenter\ListingPresenterInterface;
use App\Domain\Tag\Request\ListingRequest;
use App\Domain\Tag\Response\ListingResponse;
use App\Domain\Tag\UseCase\Listing;
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

    private MockObject&TagGatewayInterface $gateway;

    protected function setUp(): void
    {
        $this->gateway = $this->createMock(TagGatewayInterface::class);

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
        $request = new ListingRequest('photo');

        $adapter = $this->createMock(AdapterInterface::class);
        $adapter->method('getNbResults')->willReturn(10);

        $this->gateway->method('getBySlug')->willReturn(new Tag('photo', 'photo'));
        $this->gateway->method('getPaginatedAdapter')->willReturn($adapter);

        $response = $this->useCase->execute($request, $this->presenter);
        $this->assertSame(10, $response->getAdapter()->getNbResults());
    }
}
