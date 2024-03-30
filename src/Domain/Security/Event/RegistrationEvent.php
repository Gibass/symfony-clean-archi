<?php

namespace App\Domain\Security\Event;

use App\Domain\Security\Entity\UserEntityInterface;
use App\Domain\Shared\Event\EventInterface;

readonly class RegistrationEvent implements EventInterface
{
    public const USER_REGISTRATION = 'user.registration';

    public function __construct(private UserEntityInterface $user)
    {
    }

    public function getUser(): UserEntityInterface
    {
        return $this->user;
    }
}
