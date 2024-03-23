<?php

namespace App\Tests\Unit\Security;

use App\Domain\Security\Entity\User;
use App\Domain\Security\Exception\EmailNotFoundException;
use App\Domain\Security\Exception\ExpiredTokenException;
use App\Domain\Security\Exception\InvalidTokenException;
use App\Domain\Security\Gateway\UserGatewayInterface;
use App\Domain\Security\Presenter\UserVerifyPresenterInterface;
use App\Domain\Security\Request\UserVerifyRequest;
use App\Domain\Security\Response\UserVerifyResponse;
use App\Domain\Security\UseCase\UserVerify;
use App\Domain\Shared\Helper\TokenHelperInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UserVerifyTest extends TestCase
{
    private UserVerify $useCase;
    private TokenHelperInterface&MockObject $tokenHelper;
    private UserGatewayInterface&MockObject $userGateway;
    private UserVerifyPresenterInterface $presenter;

    protected function setUp(): void
    {
        $this->tokenHelper = $this->createMock(TokenHelperInterface::class);
        $this->userGateway = $this->createMock(UserGatewayInterface::class);

        $this->presenter = new class() implements UserVerifyPresenterInterface {
            public function present(UserVerifyResponse $response): UserVerifyResponse
            {
                return $response;
            }
        };

        $this->useCase = new UserVerify($this->tokenHelper, $this->userGateway);
    }

    public function testUserVerifySuccessful(): void
    {
        $request = new UserVerifyRequest('test-token');

        $this->userGateway->method('findByEmail')->willReturn(new User());

        $response = $this->useCase->execute($request, $this->presenter);
        $this->assertInstanceOf(UserVerifyResponse::class, $response);
        $this->assertNull($response->getInvalidCode());
    }

    public function testUserVerifyEmailNotFoundFailed(): void
    {
        $request = new UserVerifyRequest('test-token');

        $this->userGateway->method('findByEmail')->willReturn(null);

        $response = $this->useCase->execute($request, $this->presenter);
        $this->assertInstanceOf(UserVerifyResponse::class, $response);
        $this->assertSame(EmailNotFoundException::INVALID_CODE, $response->getInvalidCode());
    }

    /**
     * @dataProvider dataUserVerificationFailed
     */
    public function testUserVerifyFailed($token, $exception): void
    {
        $request = new UserVerifyRequest($token);

        $this->tokenHelper->method('verifyToken')->willThrowException(new $exception());

        $response = $this->useCase->execute($request, $this->presenter);
        $this->assertInstanceOf(UserVerifyResponse::class, $response);
        $this->assertSame((new \ReflectionClass($exception))->getConstant('INVALID_CODE'), $response->getInvalidCode());
    }

    public static function dataUserVerificationFailed(): \Generator
    {
        yield 'User_Verify_Expired_Token' => [
            'token' => 'expired-token',
            'exception' => ExpiredTokenException::class,
        ];

        yield 'User_Verify_Invalid_Token' => [
            'token' => 'invalid-token',
            'exception' => InvalidTokenException::class,
        ];
    }
}
