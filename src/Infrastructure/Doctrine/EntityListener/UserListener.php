<?php

namespace App\Infrastructure\Doctrine\EntityListener;

use App\Infrastructure\Doctrine\Entity\UserDoctrine;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: UserDoctrine::class)]
#[AsEntityListener(event: Events::preUpdate, method: 'preUpdate', entity: UserDoctrine::class)]
readonly class UserListener
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function prePersist(UserDoctrine $user, PrePersistEventArgs $eventArgs): void
    {
        $user->setPassword($this->encodePassword($user));
    }

    public function preUpdate(UserDoctrine $user, PreUpdateEventArgs $eventArgs): void
    {
        $user->setPassword($this->encodePassword($user));
    }

    private function encodePassword(UserDoctrine $user): string
    {
        return $this->passwordHasher->hashPassword($user, $user->getPlainPassword());
    }
}
