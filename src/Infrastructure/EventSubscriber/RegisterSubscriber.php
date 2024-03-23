<?php

namespace App\Infrastructure\EventSubscriber;

use App\Domain\Security\Event\RegistrationEvent;
use App\Domain\Security\Request\UserSendValidateRequest;
use App\Domain\Security\UseCase\UserSendValidate;
use App\UserInterface\Presenter\Mail\UserSendValidateMailPresenter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class RegisterSubscriber implements EventSubscriberInterface
{
    public function __construct(private UserSendValidate $verify, private UserSendValidateMailPresenter $presenter)
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
        $request = new UserSendValidateRequest($event->getUser());
        $this->verify->execute($request, $this->presenter);
    }
}
