<?php

namespace Integration\Security;

use App\Infrastructure\Test\IntegrationTestCase;
use Assert\AssertionFailedException;
use Symfony\Component\HttpFoundation\Response;

class RegistrationTest extends IntegrationTestCase
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
        yield ['used@mail.com', 'password', 'password', 'This email is already exist'];
    }
}
