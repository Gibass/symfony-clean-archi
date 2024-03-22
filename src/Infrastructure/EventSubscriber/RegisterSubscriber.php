<?php

namespace App\Infrastructure\EventSubscriber;

use App\Domain\Security\Event\RegistrationEvent;
use App\Domain\Security\Request\UserValidateRequest;
use App\Domain\Security\UseCase\UserValidate;
use App\UserInterface\Presenter\Mail\UserValidateMailPresenter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class RegisterSubscriber implements EventSubscriberInterface
{
    public function __construct(private UserValidate $verify, private UserValidateMailPresenter $presenter)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RegistrationEvent::USER_REGISTRATION => 'onRegistration',
        ];
    }

    public function onRegistration(RegistrationEvent $event): void
    {
        $request = new UserValidateRequest($event->getUser());
        $this->verify->execute($request, $this->presenter);
    }
}
