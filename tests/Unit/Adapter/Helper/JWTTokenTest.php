<?php

namespace App\Tests\Unit\Adapter\Helper;

use App\Domain\Security\Entity\User;
use App\Domain\Security\Exception\ExpiredTokenException;
use App\Domain\Security\Exception\InvalidTokenException;
use App\Infrastructure\Adapter\Helper\JWTToken;
use App\Tests\Common\Helper\TokenHelper;
use PHPUnit\Framework\TestCase;
use SlopeIt\ClockMock\ClockMock;

class JWTTokenTest extends TestCase
{
    private JWTToken $jwtToken;

    protected function setUp(): void
    {
        $this->jwtToken = new JWTToken(TokenHelper::JWT_SECRET);
    }

    public function testGenerateUserToken(): void
    {
        $user = (new User())
            ->setId(1)
            ->setEmail('test@test.com')
        ;

        ClockMock::freeze(new \DateTime('2024-03-20'));

        $token = $this->jwtToken->generateUserToken($user, 360);

        $this->assertSame(TokenHelper::generateTestToken([
            'user_id' => $user->getId(),
            'user_email' => $user->getEmail(),
        ], 360), $token);

        ClockMock::reset();
    }

    public function testVerifyTokenSuccess(): void
    {
        $user = (new User())
            ->setId(1)
            ->setEmail('test@test.com')
        ;

        $token = $this->jwtToken->generateUserToken($user, 360);
        $this->assertContains('test@test.com', $this->jwtToken->verifyToken($token));
    }

    /**
     * @dataProvider dataVerifyTokenFailed
     */
    public function testVerifyTokenFailed(string $token, string $exception): void
    {
        $this->expectException($exception);

        $this->jwtToken->verifyToken($token);
    }

    public static function dataVerifyTokenFailed(): \Generator
    {
        yield 'Invalid_Token' => [
            'token' => 'invalid',
            'exception' => InvalidTokenException::class,
        ];

        yield 'Invalid_Payload_OR_Signature' => [
            'token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjoxLCJ1c2VyX2VtYWlsIjoidGVzdEB0ZXN0LmNvbSIsImlhdCI6MTcxMTE3MzgzMywiZXhwIjoxNzExMTc3NDMzfQ.wXMsjW-ZmN9ySif_8DQCQdPwOAFRBtL_A4o_Yk_7U-s',
            'exception' => InvalidTokenException::class,
        ];

        ClockMock::freeze(new \DateTime('2024-03-20'));

        yield 'Expired_Token' => [
            'token' => TokenHelper::generateTestToken([
                'user_id' => 1,
                'user_email' => 'test@test.com',
            ], 120),
            'exception' => ExpiredTokenException::class,
        ];

        ClockMock::reset();
    }


}
