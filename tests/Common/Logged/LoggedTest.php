<?php

namespace App\Tests\Common\Logged;

use App\Domain\Security\Gateway\UserGatewayInterface;
use App\Infrastructure\Doctrine\Entity\UserDoctrine;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Security\Core\User\UserInterface;

trait LoggedTest
{
    protected ?UserInterface $user;

    protected static function createClient(array $options = [], array $server = []): KernelBrowser
    {
        $client = parent::createClient($options, $server);

        /** @var UserGatewayInterface $gateway */
        $gateway = $client->getContainer()->get(UserGatewayInterface::class);

        $user = $gateway->findByEmail('test@test.com');

        if ($user) {
            if (!$user instanceof UserInterface) {
                $user = (new UserDoctrine())
                    ->setId($user->getId())
                    ->setEmail($user->getEmail())
                    ->setIsVerified($user->isVerified())
                    ->setPassword($user->getPassword())
                ;
            }

            $client->loginUser($user);
        }

        return $client;
    }

    public function switchUser(KernelBrowser $client, string $email): void
    {
        /** @var UserGatewayInterface $gateway */
        $gateway = $client->getContainer()->get(UserGatewayInterface::class);

        $user = $gateway->findByEmail($email);

        if ($user) {
            $client->loginUser($user);
        }
    }
}
