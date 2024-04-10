<?php

namespace App\Tests\Common\Logged;

use App\Domain\Security\Gateway\UserGatewayInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Security\Core\User\UserInterface;

trait LoggedTest
{
    protected ?UserInterface $user;

    public function switchUser(KernelBrowser $client, string $email): void
    {
        /** @var UserGatewayInterface $gateway */
        $gateway = $client->getContainer()->get(UserGatewayInterface::class);

        $user = $gateway->findByEmail($email);

        if ($user) {
            $client->loginUser($user);
        }
    }

    protected static function createClient(array $options = [], array $server = []): KernelBrowser
    {
        $client = parent::createClient($options, $server);

        /** @var UserGatewayInterface $gateway */
        $gateway = $client->getContainer()->get(UserGatewayInterface::class);

        $user = $gateway->findByEmail('test@test.com');

        if ($user) {
            $client->loginUser($user);
        }

        return $client;
    }
}
