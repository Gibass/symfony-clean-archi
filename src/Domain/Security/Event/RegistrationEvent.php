<?php

namespace App\Domain\Security\Event;

use App\Domain\Security\Entity\User;
use App\Domain\Shared\Event\EventInterface;

readonly class RegistrationEvent implements EventInterface
{
    public const USER_REGISTRATION = 'user.registration';

    public function __construct(private User $user)
    {
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
