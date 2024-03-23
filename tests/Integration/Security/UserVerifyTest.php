<?php

namespace Integration\Security;

use App\Infrastructure\Test\IntegrationTestCase;

class UserVerifyTest extends IntegrationTestCase
{
    public function testUserVerifySuccess(): void
    {
        $client = $this->createClient();

        $client->request('GET', 'user/verify/valid-token');

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
            'token' => 'expired-token',
            'message' => 'The verification link is expired',
        ];

        yield 'User_Verify_Invalid_Token' => [
            'token' => 'invalid-token',
            'message' => 'Your link is invalid',
        ];
    }
}
