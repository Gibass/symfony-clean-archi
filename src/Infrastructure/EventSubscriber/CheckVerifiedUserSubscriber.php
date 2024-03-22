<?php

namespace App\Infrastructure\EventSubscriber;

use App\Infrastructure\Doctrine\Entity\UserDoctrine;
use App\Infrastructure\Exception\AccountNotVerifiedAuthException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;

readonly class CheckVerifiedUserSubscriber implements EventSubscriberInterface
{
    public function __construct(private RouterInterface $router)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CheckPassportEvent::class => ['onCheckPassport', -10],
            LoginFailureEvent::class => 'onLoginFailure',
        ];
    }

    /**
     * @throws \Exception
     */
    public function onCheckPassport(CheckPassportEvent $event): void
    {
        $user = $event->getPassport()->getUser();
        if (!$user instanceof UserDoctrine) {
            throw new \Exception('Unexpected User type');
        }

        if (!$user->isVerified()) {
            throw new AccountNotVerifiedAuthException();
        }
    }

    public function onLoginFailure(LoginFailureEvent $event): void
    {
        if (!$event->getException() instanceof AccountNotVerifiedAuthException) {
            return;
        }

        $response = new RedirectResponse($this->router->generate('user_not_verified'));
        $event->setResponse($response);
    }
}
