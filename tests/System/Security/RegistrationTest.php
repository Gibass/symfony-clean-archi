<?php

namespace System\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class RegistrationTest extends WebTestCase
{
    public function testRegistrationSuccess(): void
    {
        $client = self::createClient();

        $crawler = $client->request('GET', '/register');

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form')->form([
            'registration[email]' => 'email@email.com',
            'registration[plainPassword][first]' => 'password',
            'registration[plainPassword][second]' => 'password',
        ]);

        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->assertSelectorTextContains('html', '/register/success');
        $client->followRedirect();
        $this->assertSelectorTextContains('body', 'An email has been sent to your address email.');
    }

    /**
     * @dataProvider dataFailedProvider
     */
    public function testRegistrationFailed($email, $password, $confirm, $message): void
    {
        $client = self::createClient();

        $crawler = $client->request('GET', '/register');

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form')->form([
            'registration[email]' => $email,
            'registration[plainPassword][first]' => $password,
            'registration[plainPassword][second]' => $confirm,
        ]);

        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('form', $message);
    }

    public function dataFailedProvider(): \Generator
    {
        yield ['', 'password', 'password', 'This value should not be blank.'];
        yield ['test', 'password', 'password', 'This value is not a valid email address.'];
        yield ['test@mail.com', '', '', 'This value should not be blank.'];
        yield ['test@mail.com', '', 'password', 'The password fields must match'];
        yield ['test@mail.com', 'pa', 'pa', 'This value is too short. It should have 6 characters or more.'];
        yield ['test@mail.com', 'password', '', 'The password fields must match'];
        yield ['test@mail.com', 'password', 'wrong', 'The password fields must match'];
        yield ['test@test.com', 'password', 'password', 'This email is already exist'];
    }
}