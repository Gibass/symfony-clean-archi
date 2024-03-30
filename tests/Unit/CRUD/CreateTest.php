<?php

namespace Unit\CRUD;

use App\Domain\Article\Entity\ArticleInterface;
use App\Domain\CRUD\Entity\CrudEntityInterface;
use App\Domain\CRUD\Gateway\CrudGatewayInterface;
use App\Domain\CRUD\Request\CreateRequest;
use App\Domain\CRUD\Response\CreateResponse;
use App\Domain\CRUD\UseCase\Create;
use App\Domain\CRUD\Validator\CrudEntityValidatorInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateTest extends TestCase
{
    private Create $useCase;
    private CrudGatewayInterface&MockObject $gateway;
    private CrudEntityValidatorInterface&MockObject $validator;

    protected function setUp(): void
    {
        $this->validator = $this->createMock(CrudEntityValidatorInterface::class);
        $this->gateway = $this->createMock(CrudGatewayInterface::class);
        $this->useCase = new Create();
    }

    public function testCreateSuccessfully(): void
    {
        $request = new CreateRequest(['id' => 1]);

        $article = $this->createMock(CrudEntityInterface::class);
        $article->method('getIdentifier')->willReturn(1);
        $this->gateway->method('create')->willReturn($article);

        $response = $this->useCase->execute($request, $this->gateway, $this->validator);

        $this->assertInstanceOf(CreateResponse::class, $response);
        $this->assertSame(1, $response->getEntity()->getIdentifier());
    }

    public function testCreateFailed(): void
    {
        $request = new CreateRequest(['id' => 1]);

        $this->validator->method('validate')->willThrowException(new \Exception('Validation Error'));

        $this->expectExceptionMessage('Validation Error');
        $this->useCase->execute($request, $this->gateway, $this->validator);
    }
}
