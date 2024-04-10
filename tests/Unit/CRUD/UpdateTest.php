<?php

namespace Unit\CRUD;

use App\Domain\CRUD\Entity\CrudEntityInterface;
use App\Domain\CRUD\Gateway\CrudGatewayInterface;
use App\Domain\CRUD\Request\UpdateRequest;
use App\Domain\CRUD\Response\UpdateResponse;
use App\Domain\CRUD\UseCase\Update;
use App\Domain\CRUD\Validator\CrudEntityValidatorInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UpdateTest extends TestCase
{
    private Update $useCase;
    private CrudGatewayInterface&MockObject $gateway;
    private CrudEntityValidatorInterface&MockObject $validator;

    protected function setUp(): void
    {
        $this->validator = $this->createMock(CrudEntityValidatorInterface::class);
        $this->gateway = $this->createMock(CrudGatewayInterface::class);
        $this->useCase = new Update();
    }

    public function testUpdateSuccessfully(): void
    {
        $article = $this->createMock(CrudEntityInterface::class);
        $request = new UpdateRequest($article);

        $article->method('getIdentifier')->willReturn(1);
        $this->gateway->method('update')->willReturn($article);

        $response = $this->useCase->execute($request, $this->gateway, $this->validator);

        $this->assertInstanceOf(UpdateResponse::class, $response);
        $this->assertSame(1, $response->getEntity()->getIdentifier());
    }

    public function testCreateFailed(): void
    {
        $article = $this->createMock(CrudEntityInterface::class);
        $request = new UpdateRequest($article);

        $this->validator->method('validate')->willThrowException(new \Exception('Validation Error'));

        $this->expectExceptionMessage('Validation Error');
        $this->useCase->execute($request, $this->gateway, $this->validator);
    }
}
