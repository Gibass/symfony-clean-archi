<?php

namespace App\Infrastructure\Doctrine\EntityListener;

use App\Infrastructure\Doctrine\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: User::class)]
#[AsEntityListener(event: Events::preUpdate, method: 'preUpdate', entity: User::class)]
readonly class UserListener
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function prePersist(User $user, PrePersistEventArgs $eventArgs): void
    {
        $user->setPassword($this->encodePassword($user));
    }

    public function preUpdate(User $user, PreUpdateEventArgs $eventArgs): void
    {
        if ($user->getPlainPassword()) {
            $user->setPassword($this->encodePassword($user));
        }
    }

    private function encodePassword(User $user): string
    {
        return $this->passwordHasher->hashPassword($user, $user->getPlainPassword());
    }
}
