<?php

namespace App\Tests\Unit\CRUD;

use App\Domain\CRUD\Entity\CrudEntityInterface;
use App\Domain\CRUD\Exception\CrudEntityNotFoundException;
use App\Domain\CRUD\Gateway\CrudGatewayInterface;
use App\Domain\CRUD\Request\DeleteRequest;
use App\Domain\CRUD\UseCase\Delete;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DeleteTest extends TestCase
{
    private Delete $useCase;

    private CrudGatewayInterface&MockObject $gateway;

    protected function setUp(): void
    {
        $this->gateway = $this->createMock(CrudGatewayInterface::class);

        $this->useCase = new Delete();
    }

    public function testDeleteSuccessful(): void
    {
        $request = new DeleteRequest(1);

        $entity = $this->createMock(CrudEntityInterface::class);
        $this->gateway->method('getByIdentifier')->with(1)->willReturn($entity);
        $this->gateway->method('delete')->with($entity)->willReturn(true);

        $response = $this->useCase->execute($request, $this->gateway);
        $this->assertTrue($response);
    }

    public function testDeleteFailed(): void
    {
        $request = new DeleteRequest(1);
        $entity = $this->createMock(CrudEntityInterface::class);
        $this->gateway->method('getByIdentifier')->with(1)->willReturn($entity);
        $this->gateway->method('delete')->with($entity)->willReturn(false);

        $response = $this->useCase->execute($request, $this->gateway);
        $this->assertFalse($response);
    }

    public function testEntityNotFound(): void
    {
        $request = new DeleteRequest(1);

        $this->gateway->method('getByIdentifier')->with(1)->willReturn(null);

        $this->expectException(CrudEntityNotFoundException::class);

        $this->useCase->execute($request, $this->gateway);
    }
}
