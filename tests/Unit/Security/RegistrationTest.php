<?php

namespace Unit\Security;

use App\Domain\Security\Entity\UserEntityInterface;
use App\Domain\Security\Exception\EmailAlreadyExistException;
use App\Domain\Security\Gateway\UserGatewayInterface;
use App\Domain\Security\Request\RegistrationRequest;
use App\Domain\Security\Response\RegistrationResponse;
use App\Domain\Security\UseCase\Registration;
use App\Domain\Shared\Event\EventDispatcherInterface;
use Assert\AssertionFailedException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RegistrationTest extends TestCase
{
    private Registration $useCase;

    private UserGatewayInterface&MockObject $gateway;

    protected function setUp(): void
    {
        $this->gateway = $this->createMock(UserGatewayInterface::class);
        $dispatcher = $this->createMock(EventDispatcherInterface::class);

        $this->useCase = new Registration($this->gateway, $dispatcher);
    }

    public function testSuccessful(): void
    {
        $request = new RegistrationRequest('test@mail.com', 'password', 'password');

        $user = $this->createMock(UserEntityInterface::class);
        $user->method('getEmail')->willReturn('test@mail.com');
        $this->gateway->method('register')->willReturn($user);

        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(RegistrationResponse::class, $response);
        $this->assertSame('test@mail.com', $response->getUser()->getEmail());
    }

    public function testRegistrationWithExistingEmail(): void
    {
        $request = new RegistrationRequest('used@mail.com', 'password', 'password');

        $user = $this->createMock(UserEntityInterface::class);
        $this->gateway->method('findByEmail')->willReturn($user);

        $this->expectException(EmailAlreadyExistException::class);
        $this->useCase->execute($request);
    }

    /**
     * @dataProvider dataFailedProvider
     */
    public function testRegistrationFailed($email, $password, $confirmPassword): void
    {
        $request = new RegistrationRequest($email, $password, $confirmPassword);

        $this->expectException(AssertionFailedException::class);

        $this->useCase->execute($request);
    }

    public function dataFailedProvider(): \Generator
    {
        yield ['', 'password', 'password', AssertionFailedException::class];
        yield ['test', 'password', 'password', AssertionFailedException::class];
        yield ['test@mail.com', '', 'password', AssertionFailedException::class];
        yield ['test@mail.com', 'pa', 'pa', AssertionFailedException::class];
        yield ['test@mail.com', 'password', '', AssertionFailedException::class];
        yield ['test@mail.com', 'password', 'wrong', AssertionFailedException::class];
    }
}
