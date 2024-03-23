<?php

namespace System\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class LoginTest extends WebTestCase
{
    public function testLoginSuccessfully(): void
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form')->form([
            '_username' => 'test@test.com',
            '_password' => 'password',
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();
        $this->assertSelectorTextContains('body', 'Dashboard');
    }

    public function testLoginWithUnverifiedUser(): void
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form')->form([
            '_username' => 'unverified@test.com',
            '_password' => 'password',
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->assertSelectorTextContains('html', '/user/not-verified');
        $client->followRedirect();
        $this->assertSelectorTextContains('body', 'Your Account hasn\'t been verified.');
    }

    public function testRedirectionToDashboardIfLoggedUser(): void
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form')->form([
            '_username' => 'test@test.com',
            '_password' => 'password',
        ]);

        $client->submit($form);

        $client->request('GET', '/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->assertSelectorTextContains('html', '/admin/dashboard');
    }

    /**
     * @dataProvider dataFailedLogin
     */
    public function testLoginWithBadCredentials(string $email, string $password): void
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form')->form([
            '_username' => $email,
            '_password' => $password,
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();
        $this->assertSelectorTextContains('body', 'Invalid credentials.');
    }

    public static function dataFailedLogin(): \Generator
    {
        yield 'invalid_email' => ['email' => 'invalid', 'password' => 'password'];
        yield 'invalid_password' => ['email' => 'test@test.com', 'password' => 'pass'];
        yield 'not_found_email' => ['email' => 'not-found@mail.com', 'password' => 'password'];
    }
}
