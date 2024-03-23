<?php

namespace System\Security;

use App\Tests\Common\Helper\TokenHelper;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserVerifyTest extends WebTestCase
{
    public function testUserVerifySuccess(): void
    {
        $client = $this->createClient();

        $token = TokenHelper::generateTestToken([
            'user_id' => 1,
            'user_email' => 'test@test.com',
        ], 3600);

        $client->request('GET', 'user/verify/' . $token);

        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('html', 'Your account are validated, you can Sign in now.');
    }

    /**
     * @dataProvider dataUserVerificationFailed
     */
    public function testUserVerifyFailed(string $token, string $message): void
    {
        $client = $this->createClient();

        $client->request('GET', 'user/verify/' . $token);

        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('html', $message);
    }

    public static function dataUserVerificationFailed(): \Generator
    {
        yield 'User_Verify_Expired_Token' => [
            'token' => TokenHelper::generateTestToken([
                'user_id' => 1,
                'user_email' => 'test@test.com',
            ], 3600, TokenHelper::JWT_SECRET, new \DateTimeImmutable('2024-03-20')),
            'message' => 'The verification link is expired',
        ];

        yield 'User_Verify_Invalid_Token' => [
            'token' => 'invalid-token',
            'message' => 'Your link is invalid',
        ];

        yield 'User_Verify_User_not_found' => [
            'token' => TokenHelper::generateTestToken([
                'user_id' => 10,
                'user_email' => 'not-found@test.com',
            ], 3600),
            'message' => 'User no longer exists',
        ];
    }
}
