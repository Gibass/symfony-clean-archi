<?php

declare(strict_types=1);

namespace App\Core\UserInterface\Presenter;

use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

abstract class AbstractPresenter implements ServiceSubscriberInterface
{
    public function __construct(private readonly ContainerInterface $locator)
    {
    }

    public static function getSubscribedServices(): array
    {
        return [
            'router' => '?'.RouterInterface::class,
            'request_stack' => '?'.RequestStack::class,
            'http_kernel' => '?'.HttpKernelInterface::class,
            'serializer' => '?'.SerializerInterface::class,
            'security.token_storage' => '?'.TokenStorageInterface::class,
            'security.csrf.token_manager' => '?'.CsrfTokenManagerInterface::class,
            'parameter_bag' => '?'.ContainerBagInterface::class,
        ];
    }

    public function getService(string $name): mixed
    {
        if (!$this->locator->has($name)) {
            throw new \LogicException(\sprintf('You cannot use the "%s" service. The bundle may be not installed', $name));
        }

        return $this->locator->get($name);
    }

    protected function getUser(): ?UserInterface
    {
        if (null === $token = $this->locator->get('security.token_storage')->getToken()) {
            return null;
        }

        return $token->getUser();
    }
}
